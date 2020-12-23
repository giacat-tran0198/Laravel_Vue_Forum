<script>
import Replies from "../components/Replies.vue"
export default {
    name: "Thread",
    components: {Replies},
    props: ['initialRepliesCount'],
    data(){
        return {
            repliesCount: this.initialRepliesCount,
        }
    }
}
</script>

<style scoped>

</style>
