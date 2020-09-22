<template>
    <div>
        <div class="level mb-3">
            
            <img :src="avatar" alt="" width="50" height="50" class="rounded mr-3">
            <h1>
                {{ user.name }}
                <!-- <small>Since {{ $profileUser->created_at->diffForHumans() }}</small> -->
            </h1>
        </div>

        <form enctype="multipart/form-data" v-if="canUpdate">

            <image-upload @loaded="onLoad"></image-upload>

        </form>

    </div>
</template>

<script>
    import ImageUpload from './ImageUpload'
    export default {
        props: ['user'],
        components: {
            ImageUpload
        },
        data() {
            return {
                avatar: this.user.avatar_path
            }
        },

        computed: {

            canUpdate() {
                return this.authorize(user => this.user.id == user.id)
            }
        },
        methods: {
            onLoad (data) {

                this.avatar = data.src

                this.persist(data.file)
            },

            persist(file) {
                let data = new FormData()

                data.append('avatar', file)

                axios.post(`/users/${this.user.name}/avatar`, data)
                .then(() => {
                    flash('Avatar uploaded!')
                })
            }
        }
    }
</script>