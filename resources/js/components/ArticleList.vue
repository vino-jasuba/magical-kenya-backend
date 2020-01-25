<style scoped>
    .action-link {
        cursor: pointer;
    }
</style>

<template>
    <div class="col">
        <activity v-for="article in data.data" :key="article.id" :article="article" :type="article_type" :target_url="target_url"></activity>
    </div>
</template>

<script>
    import activity from "../components/Article";
    export default {
        props: ['article_type', 'target_url'],
        data() {
            return {
               data: [],
            };
        },

        mounted() {
            axios.get(this.target_url)
                .then(response => {
                    this.data = {...response.data}
                    console.log({...this.data})
                }).catch(error => {
                    console.log({...error.response.data})
                })
        },

        methods: {

        }
    }
</script>
