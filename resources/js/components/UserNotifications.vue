<template>
    <li class="nav-item dropdown" v-if="notifications.length">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                <path class="heroicon-ui" d="M15 19a3 3 0 0 1-6 0H4a1 1 0 0 1 0-2h1v-6a7 7 0 0 1 4.02-6.34 3 3 0 0 1 5.96 0A7 7 0 0 1 19 11v6h1a1 1 0 0 1 0 2h-5zm-4 0a1 1 0 0 0 2 0h-2zm0-12.9A5 5 0 0 0 7 11v6h10v-6a5 5 0 0 0-4-4.9V5a1 1 0 0 0-2 0v1.1z"/>
            </svg> <span class="caret"></span>
        </a>

        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <li v-for="notification in notifications" :key="notification.id">
                
                <a 
                    class="dropdown-item" 
                    :href="notification.data.link" 
                    v-text="notification.data.message" 
                    @click="markAsRead(notification)"
                ></a>
            </li>

        </div>
    </li>
</template>

<script>
    export default {
        data() {
            return {
                notifications: false
            }
        },

        methods: {
            markAsRead(notification) {
                axios.delete(`/profiles/${window.App.user.data.name}/notifications/${notification.id}`)
            }
        },

        created() {
            axios.get(`/profiles/${window.App.user.data.name}/notifications`)
                .then(response => this.notifications = response.data)
        }
    }
</script>