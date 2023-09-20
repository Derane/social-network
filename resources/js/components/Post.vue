<script>
export default {
    name: 'Post',
    props: [
        'post'
    ],
    methods: {
        toggleLike(post) {
            console.log(post);
            axios.post(`/api/posts/${post.id}/toggle-like`)
                .then(res => {
                    post.is_liked = res.data.is_liked
                    post.likes_count = res.data.likes_count
                })
        },

    }
}
</script>

<template>
    <h1 class="mb-8 pb-8 border-b border-gray-400">Posts</h1>
    <div class="mb-8 pb-8 border-b border-gray-400">
        <h1>{{ post.title }}</h1>
        <img class="my-3 mx-auto" v-if="post.image_url" :src="post.image_url" :alt="post.title"/>
        <p>{{ post.content }}</p>
        <div class="flex justify-between mt-2  items-center">
            <div class="flex">
            <svg @click.prevent="toggleLike(post)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                 stroke-width="1.5"
                 stroke="currentColor"
                 :class="['mr-2 stroke-pink-500 cursor-pointer hover:fill-pink-500 w-6 h-6', post.is_liked
                 ?'fill-pink-500'
                  : 'fill-white']">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
            </svg>
                <p>{{post.likes_count}}</p>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
