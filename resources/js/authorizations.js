let user = window.App.user;

module.exports = {
    updateReply (reply) {
        return parseInt(reply.user_id) === user.id;
    }
};
