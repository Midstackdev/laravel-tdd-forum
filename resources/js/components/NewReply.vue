<template>
    <div>
        <div v-if="authenticated">         
            <div class="form-group">
                <textarea 
                    name="body" 
                    id="body" 
                    class="form-control" 
                    placeholder="Have something to say?" 
                    rows="5" 
                    v-model="body"
                ></textarea>
            </div>
            <button type="submit" class="btn btn-primary" @click="addReply">Post</button>
        </div>
        <p class="text-center" v-else>Please <a href="/login">sign in</a> to participate in discussion.</p>
    </div>
</template>

<script>
    
    export default {
        props: ['endpoint'],
        data () {
            return {
                body: ''
            }
        },

        computed: {
            authenticated() {
                return window.App.user.authenticated
            }
        },

        methods: {
            addReply() {
                axios.post(this.endpoint, { body: this.body })
                .then(response => {
                    this.body = ''

                    flash('Your reply has been posted.')

                    this.$emit('created', response.data)
                })
            }
        }
    }
</script>