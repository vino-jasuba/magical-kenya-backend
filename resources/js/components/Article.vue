<style>
    .action-link {
        cursor: pointer;
    }

    .clipped-text p:not(:first-child) {
        display: none;
    }
</style>

<template>
    <div class="col">
        <div class="card shadow-sm mt-4" style="width: 18rem;">
            <div :style="{ 'background-image': `url(${getPreviewImage()})` }" style="width:18rem; height: 18rem; background-size: cover; background-position: center center;" ></div>
            <!-- <img class="card-img-top" :src="getPreviewImage()" alt="Card image cap"> -->
            <div class="card-body">
                <h5 v-if="type == 'event'" class="card-title">{{article.title}}</h5>
                <h5 v-else class="card-title">{{article.name}}</h5>
                <!-- <div v-html="article.description" class="card-text clipped-text"></div> -->
                <a v-if="type == 'experience' || type == 'event'" :href="`${target_url}/${article.id}`" class="btn btn-primary">See More</a>
                <a v-else :href="`${target_url}/${article.slug}`" class="btn btn-primary">See More</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['article', 'type', 'target_url'],
        methods: {
            getPreviewImage() {
                if (this.article.carousel.length) {
                    return this.article.carousel[0].file_path;
                }

                return "https://via.placeholder.com/300.png/09f/fff";
            }
        }
    }
</script>
