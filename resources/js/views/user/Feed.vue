<template>
    <div class="w-96 mx-auto">

        <div v-if="posts">
            <Post v-for="post in posts" :post="post"></Post>
        </div>

    </div>
</template>

<script>
import Post from "../../components/Post.vue";

export default {
    name: "Feed",

    data() {
        return {
            posts: [],
        }
    },

    mounted() {
        this.getPosts()
    },
    components: {
        Post
    },
    methods: {

        getPosts() {
            axios.get(`/api/users/followed-posts`)
                .then(res => {
                    this.posts = res.data.data
                })
        },
        toggleFollowing(user) {
            axios.get(`/api/users/${user.id}/toggle-following`)
                .then(res => {
                    user.is_followed = res.data.is_followed;
                })
        }


    }
}
</script>

<style scoped>

</style>
