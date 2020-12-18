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

        }
    }
}
</script>
