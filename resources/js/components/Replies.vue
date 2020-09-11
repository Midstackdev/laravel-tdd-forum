<template>
    <div>
        <div v-for="reply in items" :key="reply.id">
            <reply :data="reply" @deleted="remove(reply.id)"></reply>
        </div>

        <new-reply :endpoint="endpoint" @created="add"></new-reply>
    </div>
</template>

<script>
    import Reply from './Reply'
    import NewReply from './NewReply'

    export default {
        props: ['data'],
        components: {
            Reply,
            NewReply
        },

        data () {
            return  {
                items: this.data,
                endpoint: `${location.pathname}/replies`
            }
        },

        methods: {
            add(reply) {
                this.items.push(reply)

                this.$emit('added')
            },

            remove(id) {
                this.items = this.items.filter(item => item.id != id)

                this.$emit('removed')

                flash('Your reply has been deleted.')
            }
        },
    }
</script>