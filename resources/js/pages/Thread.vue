<script>
import Replies from "../components/reply/Replies.vue";
import SubscribeButton from "../components/SubscribeButton";
export default {
    name: "Thread",
    components: {Replies, SubscribeButton},
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
