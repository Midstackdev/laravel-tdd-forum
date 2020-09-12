<template>
    <div>
        <div v-for="reply in items" :key="reply.id">
            <reply :data="reply" @deleted="remove(reply.id)"></reply>
        </div>

        <paginator :dataSet="dataSet" @chnaged="fetch"></paginator>

        <new-reply @created="add"></new-reply>
    </div>
</template>

<script>
    import Reply from './Reply'
    import NewReply from './NewReply'
    import Paginator from './Paginator'
    import collection from '../mixins/collection'

    export default {
        props: [],
        components: {
            Reply,
            NewReply,
            Paginator
        },

        mixins: [collection],

        data () {
            return  {
                dataSet: false
            }
        },

        methods: {
            fetch(page) {
                axios.get(this.url(page))
                .then(this.refresh)
            },

            url(page) {
                if(!page) {
                    let query = location.search.match(/page=(\d+)/)

                    page = query ? query[1] : 1
                }

                return `${location.pathname}/replies?page=${page}`
            },

            refresh({data}) {
                this.dataSet = data
                this.items = data.data

                window.scrollTo(0, 0)
            },

        },

        created() {
            this.fetch()
        }
    }
</script>