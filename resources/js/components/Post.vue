<script>
export default {
    name:'Post',
    props: [
        'post'
    ]
}
</script>

<template>
        <h1 class="mb-8 pb-8 border-b border-gray-400">Posts</h1>
        <div class="mb-8 pb-8 border-b border-gray-400">
            <h1>{{ post.title }}</h1>
            <img class="my-3 mx-auto" v-if="post.image_url" :src="post.image_url" :alt="post.title"/>
            <p>{{post.content}}</p>
        </div>
</template>

<style scoped>

</style>
