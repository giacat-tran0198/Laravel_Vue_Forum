<script>
export default {
    name: "Reply",
    props: ['attributes'],
    data() {
        return {
            editing: false,
            body: this.attributes.body,
        }
    },
    methods: {
        update() {
            axios.patch('/replies/' + this.attributes.id, {
                body: this.body,
            }).then(() => {
                this.editing = false;
                flash('Mis à jour')
            }).catch(e => {
                console.log(e)
            })
        },

        destroy(){
            axios.delete('/replies/'+this.attributes.id);
            $(this.$el).fadeOut(300, () => {
                flash("Votre commentaire a été supprimé.");
            });

        }
    }
}
</script>
