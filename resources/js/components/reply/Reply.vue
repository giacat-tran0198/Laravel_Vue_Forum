<template>
    <div :id="'reply-'+id" class="card my-3">
        <div class="card-header">
            <div class="level">
                <h6 class="flex">
                    <a :href="'/profiles/'+data.owner.name" v-text="data.owner.name">
                    </a> a publié <span v-text="ago"></span> ...
                </h6>
                <div v-if="signedIn">
                    <favorite :reply="data"></favorite>
                </div>

            </div>
        </div>
        <div class="card-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                </div>
                <button class="btn btn-primary btn-sm" @click="update">Actualiser</button>
                <button class="btn btn-link btn-sm" @click="editing = false">Annuler</button>
            </div>
            <div v-else v-text="body"></div>
        </div>
        <div class="card-footer level" v-if="canUpdate">
            <button class="btn btn-info btn-sm mr-1" @click="editing = true">Modifier</button>
            <button class="btn btn-danger btn-sm mr-1" @click="destroy">Supprimer</button>
        </div>
    </div>
</template>
<script>
import Favorite from '../Favorite';
import moment from 'moment'
import 'moment/locale/fr'
export default {
    name: "Reply",
    props: ['data'],
    components: {Favorite},
    data() {
        return {
            editing: false,
            id: this.data.id,
            body: this.data.body,
        }
    },
    computed: {
        signedIn() {
            return window.App.signedIn;
        },
        canUpdate() {
            return this.authorize(user => this.data.user_id == user.id)
        },
        ago(){
            return moment(this.data.created_at).locale('fr').fromNow();
        }
    },
    methods: {
        update() {
            axios.patch('/replies/' + this.data.id, {
                body: this.body,
            }).then(() => {
                this.editing = false;
                flash('Mis à jour')
            }).catch(e => {
                console.log(e)
            })
        },

        destroy() {
            axios.delete('/replies/' + this.data.id);
            this.$emit('deleted', this.data.id);
        }
    }
}
</script>
