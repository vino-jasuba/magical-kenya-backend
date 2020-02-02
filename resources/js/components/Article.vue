<style>
.action-link {
  cursor: pointer;
}
</style>

<template>
  <div class="col">
    <div class="card shadow-sm mt-4" style="width: 18rem;">
      <div
        :style="{ 'background-image': `url(${getPreviewImage()})` }"
        style="width:18rem; height: 18rem; background-size: cover; background-position: center center;"
      ></div>
      <div class="card-body">
        <div v-if="type == 'event'">
          <h5 class="card-title">{{article.title}}</h5>
          <h6>{{new Date(article.start_date)}}</h6>
        </div>
        <h5 v-else class="card-title">{{article.name}}</h5>
        <a
          v-if="type == 'experience' || type == 'event'"
          :href="`${target_url}/${article.id}`"
          class="btn btn-primary"
        >See More</a>
        <a v-else :href="`${target_url}/${article.slug}`" class="btn btn-primary">See More</a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["article", "type", "target_url"],
  methods: {
    getPreviewImage() {
      if (this.article.carousel.length) {
        return this.article.carousel[0].file_path;
      }

      return "https://via.placeholder.com/300.png/09f/fff";
    }
  }
};
</script>
