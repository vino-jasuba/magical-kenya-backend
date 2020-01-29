<style scoped>
    .action-link {
        cursor: pointer;
    }
</style>

<template>
    <div class="col">
        <div class="card shadow-sm mt-4" style="width: 18rem;">
            <img class="card-img-top" src="#" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">{{article.name}}</h5>
                <div v-html="article.description" class="card-text"></div>
                <a :href="`${target_url}/${article.slug}`" class="btn btn-primary">See More</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['article', 'type', 'target_url'],
        data() {
            return {
                tokens: []
            };
        },

        mounted() {

        },

        methods: {

        }
    }
</script>
