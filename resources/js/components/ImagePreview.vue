<style scoped>
.action-link {
  cursor: pointer;
}
.image-input {
  display: block;
  width: 100px;
  height: 100px;
  cursor: pointer;
  background-size: cover;
  background-position: center center;
}

.placeholder {
  background: #f0f0f0;
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  color: #333;
  font-size: 18px;
  font-family: Helvetica;
}

.placeholder:hover {
  background: #e0e0e0;
}

.file-input {
  display: none;
}
</style>

<template>
  <div class="w-50 mx-auto row">
    <div class="form-group col-auto text-right">
      <div
        class="image-input"
        :style="{ 'background-image': `url(${image.fileBase64Encoded})` }"
      >
      </div>
    </div>
    <div class="form-group text-right col">
      <label
        class="form-control-label"
        for="image_description"
        style="margin-right: 50%;"
      >Image Brief</label>
      <div class="row">
        <input
          class="form-control form-control-alternative col"
          @input="handleDescriptionChanged"
          v-model="description"
          type="text"
          name="image_description"
          :id="`image_description-${image.id}`"
        />
        <button class="btn btn-danger" @click="removeImage"><i class="fa fa-trash"></i></button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["image"],
  data() {
    return {
      id: null,
      file: null,
      description: null,
    };
  },

  methods: {
    handleDescriptionChanged() {
      this.$emit("imageDescriptionChanged", {
        id: this.image.id,
        description: this.description
      });
    },

    removeImage() {
      this.$emit('imageRemoved', {id: this.image.id});
    }
  }
};
</script>
