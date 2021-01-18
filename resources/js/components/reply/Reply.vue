<template>
    <div :id="'reply-'+id" class="card my-3" :class="isBest ? 'border-success' : ''">
        <div class="card-header">
            <div class="level">
                <h6 class="flex">
                    <a :href="'/profiles/'+reply.owner.name" v-text="reply.owner.name">
                    </a> a publié <span v-text="ago"></span> ...
                </h6>
                <div v-if="signedIn">
                    <favorite :reply="reply"></favorite>
                </div>

            </div>
        </div>
        <div class="card-body">
            <div v-if="editing">
                <form @submit="update">
                    <div class="form-group">
                        <textarea class="form-control" v-html="body" required></textarea>
                    </div>
                    <button class="btn btn-primary btn-sm">Actualiser</button>
                    <button class="btn btn-link btn-sm" @click="editing = false" type="button">Annuler</button>
                </form>
            </div>
            <div v-else v-html="body"></div>
        </div>
        <div class="card-footer level" v-if="authorize('owns', reply) || authorize('owns', reply.thread)">
            <div v-if="authorize('owns', reply)">
                <button class="btn btn-info btn-sm mr-1" @click="editing = true">Modifier</button>
                <button class="btn btn-danger btn-sm mr-1" @click="destroy">Supprimer</button>
            </div>
            <button class="btn btn-light btn-sm ml-a" @click="markBestReply" v-if="authorize('owns', reply.thread)">Le
                meilleur
            </button>
        </div>
    </div>
</template>
<script>
import Favorite from '../Favorite';
import moment from 'moment'
import 'moment/locale/fr'

export default {
    name: "Reply",
    props: ['reply'],
    components: {Favorite},
    data() {
        return {
            editing: false,
            id: this.reply.id,
            body: this.reply.body,
            isBest: this.reply.isBest,
        }
    },
    computed: {
        ago() {
            return moment(this.reply.created_at).locale('fr').fromNow();
        }
    },
    created() {
        window.events.$on('best-reply-selected', id => {
            this.isBest = (id === this.id);
        });
    },
    methods: {
        update() {
            axios.patch('/replies/' + this.id, {
                body: this.body,
            }).then(() => {
                this.editing = false;
                flash('Mis à jour')
            }).catch(error => {
                flash(error.response.data, 'danger');
            })
        },

        destroy() {
            axios.delete('/replies/' + this.id);
            this.$emit('deleted', this.data.id);
        },

        markBestReply() {
            axios.post('/replies/' + this.id + '/best');
            window.events.$emit('best-reply-selected', this.id);
        },
    }
}
</script>
