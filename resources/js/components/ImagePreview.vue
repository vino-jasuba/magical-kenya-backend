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
        :style="{ 'background-image': `url(${imageData})` }"
        @click="chooseImage"
      >
        <span v-if="!imageData" class="placeholder">
          <i class="fa fa-plus"></i>
        </span>
        <input class="file-input" ref="fileInput" type="file" @input="onSelectFile" />
      </div>
    </div>
    <div v-if="showDescriptionField" class="form-group text-right col">
      <label
        class="form-control-label"
        for="image_description"
        style="margin-right: 50%;"
      >Image Brief</label>
      <div class="row">
        <input
          class="form-control form-control-alternative col"
          @input="handleDescriptionChanged"
          v-model="imageDescription"
          type="text"
          name="image_description"
          id="image_description"
        />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["imageIdentifier"],
  data() {
    return {
      imageData: "",
      imageDescription: "",
      showDescriptionField: false,
      file: null,
      id: null,
      hasBackground: false,
    };
  },

  mounted() {
    this.id = this.imageIdentifier;
  },

  methods: {
    chooseImage() {
      if (!this.imageData) {
        this.$refs.fileInput.click();
      }
    },

    onSelectFile() {
      const input = this.$refs.fileInput;
      const files = input.files;

      if (files && files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
          this.imageData = e.target.result;
        };
        reader.readAsDataURL(files[0]);
        this.showDescriptionField = true;
        this.file = files[0];
        this.$emit("imageSelected", {
          id: this.id,
          file: this.file,
          description: this.imageDescription
        });
      }
    },

    handleDescriptionChanged() {
      this.$emit("imageDescriptionChanged", {
        id: this.id,
        file: this.file,
        description: this.imageDescription
      });
    }
  }
};
</script>
