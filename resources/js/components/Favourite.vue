<template>
    <button class="" :class="classes" @click="toggle">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" class="text-white">
            <path d="M12.76 3.76a6 6 0 0 1 8.48 8.48l-8.53 8.54a1 1 0 0 1-1.42 0l-8.53-8.54a6 6 0 0 1 8.48-8.48l.76.75.76-.75zm7.07 7.07a4 4 0 1 0-5.66-5.66l-1.46 1.47a1 1 0 0 1-1.42 0L9.83 5.17a4 4 0 1 0-5.66 5.66L12 18.66l7.83-7.83z"/>
        </svg>
        <span v-text="count"></span>
    </button>
</template>

<script>
    export default {
        props: ['reply'],
        data () {
            return  {
                count: this.reply.favouritesCount,
                active: this.reply.isFavourited
            }
        },

        computed: {
            classes() {
                return ['btn', this.active ? 'btn-info' : 'btn-ligth' ]
            },

            endpoint() {
                return `/replies/${this.reply.id}/favourites`
            }
        },

        methods: {
            toggle () {
                return this.active ? this.destroy() : this.create()
            },

            create() {
                axios.post(this.endpoint)

                this.active = true
                this.count++
            },

            destroy () {
                axios.delete(this.endpoint)
                this.active = false
                this.count--
            }
        }
    }
</script>