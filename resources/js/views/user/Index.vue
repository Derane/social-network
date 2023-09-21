<template>
    <div class="w-96 mx-auto">
        <div v-if="users">
            <div class="flex justify-between items-center mb-6 pb-6 border-b border-gray-450" v-for="user in users">
                <router-link :to="{name: 'user.show', params:{id:user.id}}">
                    <p>{{ user.id }}</p>
                    <p>{{ user.name }}</p>
                    <p>{{ user.email }}</p>
                </router-link>
                <div>
                    <a @click.prevent="toggleFollowing(user)" :class="['block p-2 w-32 text-center rounded-3xl',
                    user.is_followed
                    ? 'bg-white text-sky-500 border border-blue-500'
                    : 'bg-green-600 text-white']" href="#">{{ user.is_followed ? 'Unfollow' : 'Follow' }}</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Index",

    data() {
        return {
            users: []
        }
    },
    mounted() {
        this.getUsers()
    },

    methods: {
        getUsers() {
            axios.get('/api/users/')
                .then(res => {
                    this.users = res.data.data;
                })
        },
        toggleFollowing(user) {
                axios.post(`/api/users/${user.id}/toggle-following`)
                    .then(res => {
                        user.is_followed = res.data.is_followed;
                    })
        }
    }
}
</script>

<style scoped>

</style>
