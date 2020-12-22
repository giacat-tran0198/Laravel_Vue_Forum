<template>
    <button type="submit" :class="classButton" @click="toggle">
        <span :class="classHeart"></span>
        <span v-text="favoritesCount"></span>
    </button>
</template>

<script>
export default {
    name: "Favorite",
    props: ['reply'],
    data() {
        return {
            favoritesCount: this.reply.favoritesCount,
            isFavorited: this.reply.isFavorited,
        }
    },

    computed: {
        classButton() {
            return ['btn', this.isFavorited ? 'btn-primary' : 'btn-secondary'];
        },
        classHeart(){
            return [this.isFavorited ? 'fas' : 'far', 'fa-heart'];
        },
        endpoint(){
            return '/replies/' + this.reply.id + '/favorites';
        }
    },

    methods: {
        toggle() {
            return this.isFavorited ? this.destroy() : this.create();
        },
        destroy(){
            axios.delete(this.endpoint);
            this.isFavorited = false;
            this.favoritesCount--;
        },
        create(){
            axios.post(this.endpoint);
            this.isFavorited = true;
            this.favoritesCount++;
        },
    }
}
</script>

<style scoped>

</style>
