<template>
    <div class="mt-3">
        <div v-if="signedIn">
            <div class="form-group">
                <textarea name="body" id="body" class="form-control" placeholder="Que voulez-vous dire?" rows="5"
                          required
                          v-model="body"></textarea>
            </div>
            <button type="submit" class="btn btn-primary" @click="addReply">Publier</button>
        </div>

        <p class="text-center" v-else>
            Veuillez vous <a href="/login">connecter</a> pour participer à cette
            discussion</p>

    </div>
</template>

<script>
import Tribute from "tributejs";

export default {
    name: "NewReply",
    data() {
        return {
            body: '',
        }
    },
    mounted() {
        let tribute = new Tribute({
            // column to search against in the object (accepts function or string)
            lookup: 'value',
            // column that contains the content to insert by default
            fillAttr: 'value',
            values: function (query, cb) {
                axios.get('/api/users', {params: {name: query}})
                    .then((response) => {
                        cb(response.data);
                    });
            },
        });
        tribute.attach(document.querySelectorAll("#body"));
    },
    methods: {
        addReply() {
            axios.post(location.pathname + '/replies', {body: this.body})
                .then(({data}) => {
                    this.body = "";
                    flash('Votre commentaire a été publié');
                    this.$emit('created', data);
                })
                .catch(error => {
                    flash(error.response.data, 'danger');
                })
        }
    }
}
</script>

<style scoped>

</style>
