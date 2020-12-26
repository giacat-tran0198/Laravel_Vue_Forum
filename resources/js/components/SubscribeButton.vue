<template>
    <button :class="classesButton" @click="subcriber">S'abonner</button>
</template>

<script>
export default {
    name: "SubscribeButton",
    props: ['active'],
    computed: {
        classesButton(){
            return ['btn', this.isSubscribed ? 'btn-primary' : 'btn-light'];
        }
    },
    data(){
      return {
          isSubscribed : this.active
      }
    },
    methods:{
        subcriber(){
            axios({
                method: this.isSubscribed ? 'DELETE' : 'POST',
                url: location.pathname + '/subscriptions',
            });
            this.isSubscribed = !this.isSubscribed;
        }
    }
}
</script>

<style scoped>

</style>
