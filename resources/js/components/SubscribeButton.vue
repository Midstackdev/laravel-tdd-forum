<template>
    <div>
        <button :class="classes" @click="subscibe">Subscribe</button>
    </div>
</template>

<script>
    
    export default {
        props: ['isSusbcribedTo'],
        data() {
            return {
                active: this.isSusbcribedTo
            }
        },
        computed: {
            classes() {
                return ['btn', this.active ? 'btn-primary' : 'btn-light']
            }
        },
        methods: {
            subscibe() {
                axios[(this.active ? 'delete': 'post')](`${location.pathname}/subscriptions`)

                this.active = !this.active

                flash('Subscribed!')
            }
        }
    }
</script>