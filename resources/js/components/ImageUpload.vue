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
      <div class="image-input" @click="chooseImage">
        <span class="placeholder">
          <i class="fa fa-plus"></i>
        </span>
        <input class="file-input" ref="fileInput" type="file" @input="onSelectFile" />
      </div>
    </div>
  </div>
</template>

<script>
import uuid from "uuid/v4";

export default {
  props: ["imageIdentifier"],
  data() {
    return {
      imageData: "",
      imageDescription: "",
      showDescriptionField: false,
      file: null,
      id: null
    };
  },

  mounted() {
    this.id = this.imageIdentifier;
  },

  methods: {
    chooseImage() {
      this.id = uuid();
      this.$refs.fileInput.click();
    },

    onSelectFile() {
      const input = this.$refs.fileInput;
      const files = input.files;

      if (files && files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
          this.imageData = e.target.result;

          if (files[0].size > 5242880) {
            this.$notify({
              group: "articles",
              title: "File Too Large",
              text: "Uploaded File Exceeds Maximum Allowed File Size (5mb)",
              type: "error",
              duration: 5000
            });

            return;
          }

          this.$emit("imageSelected", {
            id: this.id,
            file: this.file,
            description: this.imageDescription,
            fileBase64Encoded: this.imageData
          });
        };
        reader.readAsDataURL(files[0]);
        this.file = files[0];
      }
    }
  }
};
</script>
