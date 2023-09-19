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
    name: "Personal",

    data() {
        return {
            posts: [],
            userId: this.$route.params.id,
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
            axios.get(`/api/users/${this.userId}/posts`)
                .then(res => {
                    this.posts = res.data.data
                })
        },



    }
}
</script>

<style scoped>

</style>
