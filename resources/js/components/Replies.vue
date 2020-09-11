<template>
    <div>
        <div v-for="reply in items" :key="reply.id">
            <reply :data="reply" @deleted="remove(reply.id)"></reply>
        </div>
    </div>
</template>

<script>
    import Reply from './Reply'

    export default {
        props: ['data'],
        components: {
            Reply
        },

        data () {
            return  {
                items: this.data
            }
        },

        methods: {
            remove(id) {
                this.items = this.items.filter(item => item.id != id)

                this.$emit('removed')
                
                flash('Your reply has been deleted.')
            }
        },
    }
</script>