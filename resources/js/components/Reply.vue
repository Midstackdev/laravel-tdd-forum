<template>
    <div :id="`reply-${data.id}`" class="card mb-2">
        <div class="card-header">
            <div class="level">
                <h5 class="flex">
                    <a :href="`/profiles/${data.owner.name}`" v-text="data.owner.name"></a> said
                    {{ data.created_at }}...
                </h5>

                <div v-if="authenticated">
                    <favourite :reply="data"></favourite>
                </div>

            </div>  
            
        </div>
        <div class="card-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea name="" v-model="body" class="form-control"></textarea>
                </div>
                <button class="btn btn-sm btn-outline-danger" @click="editing = false">Cancel</button>
                <button class="btn btn-sm btn-outline-success" @click="update">Update</button>
            </div>
            <div v-else v-text="body"></div>
        </div>

        <div class="card-footer text-muted level" v-if="canUpdate">
            <button class="btn btn-light btn-sm mr-1" type="button" @click="editing = true">Edit</button>
            <button class="btn btn-danger btn-sm mr-1" type="button" @click="destroy">Delete</button>
        </div>
    </div>
</template>
<script>
    import Favourite from './Favourite'
    export default {
        props: ['data'],
        components: {
            Favourite
        },

        data () {
            return {
                editing: false,
                body: this.data.body
            }
        },

        computed: {
            authenticated() {
                return window.App.user.authenticated
            },

            canUpdate() {
                return this.authorize(user => this.data.user_id == user.id)
            }
        },

        methods: {
            update () {
                axios.patch(`/replies/${this.data.id}`, {
                    body: this.body
                })

                this.editing = false

                flash('Updated!')
            },

            destroy () {
                axios.delete(`/replies/${this.data.id}`)

                this.$emit('deleted', this.data.id)

            }
        },

        mounted () {
            console.log(window.App.user.data.id)
        }
    }
</script>
