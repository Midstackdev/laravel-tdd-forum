export default {
    data () {
        return {
            items: []
        }
    },

    methods: {
        add(item) {
            this.items.push(item)

            this.$emit('added')
        },

        remove(id) {
            this.items = this.items.filter(item => item.id != id)

            this.$emit('removed')

            flash('Your reply has been deleted.')
        }
    }
}