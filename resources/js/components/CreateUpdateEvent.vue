<style>
.action-link {
  cursor: pointer;
}
</style>

<template>
  <div class="card-body">
    <loading :active="isLoading" :can-cancel="true" :on-cancel="onCancel" :is-full-page="fullPage"></loading>
    <notifications group="events" />
    <form-wizard color="#5e72e4" title subtitle stepSize="xs" @on-complete="handleFormSubmit">
      <tab-content class="mt-6" title="Create Event" :before-change="validateAsync">
        <div class="form-group row text-right">
          <label for="title" class="form-control-label col-2">Event Title</label>
          <input
            class="form-control col-6"
            :class="{'is-invalid': $v.data.title.$error}"
            v-model.trim="$v.data.title.$model"
            type="text"
            name="title"
            id="title"
          />
        </div>
        <div class="form-group row text-right">
          <label for="date" class="form-control-label col-2">From</label>
          <datetime
            type="datetime"
            :minute-step="15"
            input-id="datetime-1"
            input-class="form-control col"
            v-model.trim="$v.data.start_date.$model"
          ></datetime>
        </div>
        <div class="form-group row text-right">
          <label for="from" class="form-control-label col-2">To</label>
          <datetime
            type="datetime"
            :minute-step="15"
            input-id="datetime-2"
            input-class="form-control col"
            v-model.trim="$v.data.end_date.$model"
          ></datetime>
        </div>
        <div class="form-group row text-right">
          <label for="URL" class="form-control-label col-2">URL</label>
          <input
            class="form-control col-6"
            :class="{'is-invalid': $v.data.external_url.$error}"
            v-model.trim="$v.data.external_url.$model"
            type="text"
            name="external_url"
            id="external_url"
          />
        </div>
      </tab-content>
      <tab-content title="Carousel">
        <div class="form-group row col justify-content-left align-items-center">
          <vue-select-image
            ref="imageSelectRef"
            :dataImages="headlineImages"
            :is-multiple="true"
            :selectedImages="selectedImages"
            h="100px"
            @onselectmultipleimage="onSelectMultipleImage"
          ></vue-select-image>
          <div v-if="selectedImages.length">
            <span class="btn btn-danger mr-3" @click="deleteSelectedImages">
              <i class="fa fa-trash"></i>
            </span>
            <i v-if="selectedImages.length == 1">Delete 1 Image</i>
            <i v-else>Delete {{selectedImages.length}} Images</i>
          </div>
        </div>
        <div class="form-group row text-right">
          <image-upload
            :imageIdentifier="imageUniqId"
            @imageSelected="handleSelectedImage"
          ></image-upload>
        </div>
      </tab-content>
      <tab-content title="Finish">Finish and close wizard</tab-content>
    </form-wizard>
  </div>
</template>

<script>
import Cookie from "js-cookie";
import uuid from "uuid/v4";
import { required, url } from "vuelidate/lib/validators";

export default {
  props: ["slug"],
  data() {
    return {
      data: {
        id: null,
        title: null,
        external_url: null,
        start_date: null,
        end_date: null,
        carousel: []
      },
      isEditing: false,
      imageFiles: [],
      isLoading: true,
      fullPage: true,
      target_url: "/events",
      imageUniqId: uuid(),
      dataImages: [],
      headlineImages: [],
      selectedImages: [],
      type: "event"
    };
  },
  validations: {
    data: {
      title: { required },
      external_url: { required, url },
      start_date: { required },
      end_date: { required }
    }
  },

  mounted() {
    this.editContextFetchRecord();

    axios
      .get("/dropdown-options", {
        headers: {
          Authorization: "Bearer " + Cookie.get("laravel_token")
        }
      })
      .then(res => {
        this.activities = { ...res.data }["activities"];
        this.locations = { ...res.data }["locations"];
      })
      .catch(err => {
      });
  },

  methods: {
    handleFormSubmit() {
      this.isLoading = true;
      window.location = this.target_url;
    },

    uploadEventImages() {
      return this.uploadImages("carousel");
    },

    uploadImages(useCase) {
      this.isLoading = true;

      let formData = new FormData();
      formData.set("target_key", this.data.id);
      formData.set("target_type", this.type);
      formData.set("use_case", useCase);

      const images = Object.values(this.imageFiles);

      for (let i = 0; i < images.length; i++) {
        formData.append(`files[${i}]`, images[i].file);
        formData.append(`description[${i}]`, images[i].description);
      }

      if (this.imageFiles.length) {
        return axios
          .post("/media", formData)
          .then(res => {
            this.isLoading = false;
            this.imageFiles = [];
            this.headlineImages.push({
              id: res.data.data[0].id,
              alt: res.data.data[0].description,
              src: res.data.data[0].file_path
            });
            return true;
          })
          .catch(err => {
            this.isLoading = false;
            this.processErrorResponse(err);
          });
      }

      this.isLoading = false;
      this.imageFiles = [];
      return true;
    },

    renderLoadedImages() {
      this.headlineImages = this.data.carousel.map(item => ({
        id: item.id,
        src: item.file_path,
        alt: item.description
      }));
    },

    editContextFetchRecord() {
      // If we have a slug then we're in edit context therefore
      // we need to fetch the associated record
      if (this.slug) {
        this.isEditing = true;
        axios
          .get(`${this.target_url}/` + this.slug)
          .then(response => {
            this.data = { ...this.data, ...response.data.data };
          })
          .catch(error => {
            this.processErrorResponse(error);
          });
      }

      this.isLoading = false;
    },

    updateRecordRequest() {
      return axios
        .patch(`${this.target_url}/` + this.slug, {
          ...this.data,
          headers: {
            Authorization: "Bearer " + Cookie.get("laravel_token")
          }
        })
        .then(res => {
          this.data = { ...res.data.data };
          this.renderLoadedImages();
          return true;
        })
        .catch(error => {
          this.processErrorResponse(error);
        });
    },

    createRecordRequest() {
      return axios
        .post(this.target_url, {
          ...this.data,
          headers: {
            Authorization: "Bearer " + Cookie.get("laravel_token")
          }
        })
        .then(res => {
          this.data = { ...res.data.data };
          this.renderLoadedImages();
          return true;
        })
        .catch(error => {
          this.processErrorResponse(error);
        });
    },

    onCancel() {
    },

    onSelectMultipleImage(images) {
      this.selectedImages = images;
    },

    deleteSelectedImages() {
      this.selectedImages.map(item => {
        axios
          .delete("/media/" + item.id)
          .then(res => {
            this.isLoading = false;
            this.headlineImages = this.headlineImages.filter(
              a => a.id != item.id
            );

            this.selectedImages = [];
            this.$refs.imageSelectRef.resetMultipleSelection();
          })
          .catch(err => {
            this.processErrorResponse(err);
          });
      });

      this.isLoading = false;
    },

    handleSelectedImage(uploadedFile) {
      this.imageFiles.push(uploadedFile);
      this.uploadImages("carousel");
    },

    handleDescriptionChanged(value) {
      for (let i = 0; i < this.imageFiles.length; i++) {
        const targetImage = this.imageFiles[i];

        if (targetImage.id == value.id) {
          this.imageFiles[i] = {
            ...this.imageFiles[i],
            ...value
          };
        }
      }
    },

    generateUniqueIdForNextImage() {
      this.imageUniqId = uuid();
    },

    /**
     * Validate the request data. This validation is handled based on whether the
     * resource in question is an activity or a location resource item
     */
    validateAsync() {
      let validData =
        !this.$v.data.title.$invalid &&
        !this.$v.data.start_date.$invalid &&
        !this.$v.data.end_date.$invalid &&
        !this.$v.data.external_url.$invalid;

      if (!validData) {
        this.$notify({
          group: "events",
          title: "Error",
          text: "You cannot proceed without filling all the fields",
          type: "error",
          duration: 5000
        });

        return false;
      }

      if (this.isEditing) {
        return this.updateRecordRequest();
      }

      return this.createRecordRequest();
    },

    validateImages() {
      return true;
    },

    processErrorResponse(error) {
      const data = error.response.data;
      const errors = Object.values(error.response.data.errors);
      errors.map(e => {
        this.$notify({
          group: "articles",
          title: data.message,
          text: e[0],
          type: "error",
          duration: 5000
        });
      });

      throw error;
    }
  }
};
</script>
