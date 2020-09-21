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
    import 'at.js'
    import 'jquery.caret'

    export default {
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
                axios.post(`${location.pathname}/replies`, { body: this.body })
                .then(response => {
                    this.body = ''

                    flash('Your reply has been posted.')

                    this.$emit('created', response.data)
                })
                .catch(error => {
                    flash(error.response.data, 'danger')
                })
            }
        },

        mounted() {
            $('#body').atwho({
                at: "@",
                delay: 750,
                callbacks: {
                    remoteFilter: function(query, callback) {
                        $.getJSON('/api/users', {name: query}, function(usernames) {
                            callback(usernames)
                        })
                    }
                }
            })
        }
    }
</script>