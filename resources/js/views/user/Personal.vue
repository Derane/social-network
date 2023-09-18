<template>
    <div class="w-96 mx-auto">

        <div>
            <input v-model="title" class="w-96 mb-3 rounded-3xl border p-2 border-slate-400" type="text"
                   placeholder="title">
        </div>
        <div>
            <textarea v-model="content" class="w-96 rounded-3xl mb-3 border p-2 border-slate-400" type="text"
                      placeholder="content"></textarea>
        </div>
        <div class="flex mb-3 items-center">
            <div>
                <input @change="storeImage" ref="file" type="file" class="hidden">
                <a href="#" class="block p-2 w-16 text-center text-sm rounded-3xl bg-sky-500 text-white"
                   @click.prevent="selectFile()">Image</a>
            </div>
            <div>
                <a v-if="image" @click.prevent="setImageNull" class="ml-3" href="#">Cancel</a>
            </div>
        </div>
        <div v-if="image != null">
            <img :src="image.url" alt="preview">
        </div>
        <div>
            <a href="#" @click.prevent="store"
               class="block p-2 w-32 rounded-3xl text-center bg-blue-700 text-white hover:border
               hover:bg-white hover:bord-bg-blue-700 hover:text-blue-700 ml-auto">
                Publish</a>
        </div>
    </div>
</template>
<script>
export default {
    name: "Personal",
    methods: {
        data() {
            return {
                title: '',
                content: '',
                image: ''
            }
        },
        store() {
            const id = this.image ? this.image : null;
            axios.post('/api/posts', {title: this.title, content: this.content, image_id: id})
                .then(res => {
                    console.log(res);
                })
        },
        setImageNull() {
            this.image = null
        },
        selectFile() {
            this.fileInput = this.$refs.file;
            this.fileInput.click();
        },

        storeImage(e) {
            const file = e.target.files[0]
            const formData = new FormData()
            formData.append('image', file)

            axios.post('/api/post-images', formData)
                .then(res => {
                    this.image = res.data.data
                    console.log(this.image);
                })
        }
    }
}
</script>
<style scoped>

</style>
