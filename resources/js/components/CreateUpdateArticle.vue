<style scoped>
.action-link {
  cursor: pointer;
}
</style>

<template>
  <div class="card-body">
    <loading :active="isLoading" :can-cancel="true" :on-cancel="onCancel" :is-full-page="fullPage"></loading>
    <notifications group="articles" />
    <form-wizard color="#5e72e4" title subtitle stepSize="xs" @on-complete="handleFormSubmit">
      <tab-content class="mt-6" :title="`Create ${type}`" :before-change="validateAsync">
        <div v-if="type !== 'experience'" class="form-group row text-right">
          <label class="form-control-label col-2" for="name">Name</label>
          <input
            class="form-control col-8"
            :class="{'is-invalid': $v.data.name.$error}"
            v-model.trim="$v.data.name.$model"
            type="text"
            name="name"
            id="name"
          />
        </div>
        <div v-if="type != 'experience'" class="form-group row text-right">
          <label class="form-control-label col-2" for="catchphrase">Catchphrase</label>
          <input
            class="form-control col-8"
            :class="{'is-invalid': $v.data.catchphrase.$error}"
            v-model.trim="$v.data.catchphrase.$model"
            type="text"
            name="catchphrase"
            id="catchphrase"
          />
        </div>
        <div v-if="type != 'experience'" class="form-group row text-right">
          <label class="form-control-label col-2">Color Tag</label>
          <swatches v-model="data.color_tag" color="material-light"></swatches>
        </div>
        <div v-if="type === 'experience'" class="form-group row text-right">
          <label class="form-control-label col-2">Location</label>
          <v-select
            :value="selectedLocation"
            v-model="selectedLocation"
            class="col-8"
            label="name"
            code="id"
            :options="locations"
            @input="setLocationId"
          ></v-select>
        </div>
        <div v-if="type === 'experience'" class="form-group row text-right">
          <label class="form-control-label col-2">Activity</label>
          <v-select
            :value="selectedActivity"
            v-model="selectedActivity"
            class="col-8"
            label="name"
            code="id"
            :options="activities"
            @input="setActivityId"
          ></v-select>
        </div>
        <div v-if="type === 'location'" class="form-group row text-right">
          <label for="location" class="form-control-label col-2">Location</label>
          <custom-gmap-autocomplete
            @location-changed="locationUpdated"
            :initialPosition="initialPosition"
            :shouldZoom="initialPosition !== null"
          ></custom-gmap-autocomplete>
        </div>
        <div v-if="type === 'experience'" class="form-group row text-right">
          <label class="form-control-label col-2" for="contact_name">Contact Name</label>
          <input
            class="form-control col-8"
            v-model.trim="$v.data.contact_name.$model"
            type="text"
            name="contact_name"
            id="contact_name"
          />
        </div>
        <div v-if="type === 'experience'" class="form-group row text-right">
          <label class="form-control-label col-2" for="contact_phone_number">Phone Number</label>
          <input
            class="form-control col-8"
            :class="{'is-invalid': $v.data.contact_phone_number.$error}"
            v-model.trim="$v.data.contact_phone_number.$model"
            type="text"
            name="contact_phone_number"
            id="contact_phone_number"
          />
        </div>
        <div v-if="type === 'experience'" class="form-group row text-right">
          <label for="signature" class="form-control-label col-2">Must See</label>
          <label class="custom-toggle ml-3">
            <input type="checkbox" v-model="mustSeeExperience" />
            <span class="custom-toggle-slider rounded-circle"></span>
          </label>
        </div>
        <div class="form-group row text-right">
          <label class="form-control-label col-2" for="description">Description</label>
          <ckeditor
            class="col-8"
            :editor="editor"
            v-model="$v.data.description.$model"
            :config="editorConfig"
          ></ckeditor>
        </div>
        <button data-toggle="modal" :data-target="`#modal-${data.id}`" class="btn btn-danger" style="position: absolute;bottom: 2.4rem;">Delete</button>
        <generic-modal :type="type" :id="data.id" :experiences_count="data.experiences_count"></generic-modal>
      </tab-content>
      <tab-content title="Carousel" :before-change="uploadCarouselImages">
        <div class="form-group row col justify-content-left align-items-center">
          <vue-select-image
            ref="imageSelectRef"
            :dataImages="carouselImages"
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
          <image-upload-with-description
            v-for="image in imageFiles"
            :key="image.id"
            :image="image"
            @imageDescriptionChanged="handleDescriptionChanged"
            @imageRemoved="handleImageRemoved"
          ></image-upload-with-description>
          <image-upload @imageSelected="handleSelectedImage"></image-upload>
        </div>
      </tab-content>
      <tab-content
        v-if="type != 'experience'"
        title="Background"
        :before-change="uploadBackgroundImages"
      >
        <div class="form-group row col justify-content-left align-items-center">
          <vue-select-image
            ref="imageSelectRef"
            :dataImages="backgroundImages"
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
          <image-upload-with-description
            v-for="image in imageFiles"
            :key="image.id"
            :image="image"
            @imageDescriptionChanged="handleDescriptionChanged"
            @imageRemoved="handleImageRemoved"
          ></image-upload-with-description>
          <image-upload @imageSelected="handleSelectedImage"></image-upload>
        </div>
      </tab-content>
      <tab-content title="Upload">Upload media files</tab-content>
    </form-wizard>
  </div>
</template>

<script>
import "vue-swatches/dist/vue-swatches.min.css";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import Cookie from "js-cookie";
import Swatches from "vue-swatches";
import { required, requiredIf } from "vuelidate/lib/validators";

export default {
  props: ["slug", "type"],
  components: { Swatches },
  data() {
    return {
      data: {
        name: null,
        catchphrase: null,
        description: null,
        icon: "/path/to/icon/file",
        lat: null,
        activity_id: null,
        location_id: null,
        contact_name: null,
        contact_phone_number: null,
        experiences_count: 0,
        lng: null,
        carousel: [],
        background: [],
        color_tag: "#1CA085",
        tags: null
      },
      editor: ClassicEditor,
      editorConfig: {
        toolbar: [
          "heading",
          "|",
          "bold",
          "italic",
          "link",
          "bulletedList",
          "numberedList",
          "blockQuote"
        ]
      },
      target_url: null,
      isEditing: false,
      initialPosition: null,
      imageFiles: [],
      isLoading: true,
      fullPage: true,
      loadingWizard: true,
      activities: [],
      locations: [],
      selectedLocation: null,
      selectedActivity: null,
      mustSeeExperience: false,
      dataImages: [],
      carouselImages: [],
      backgroundImages: [],
      selectedImages: [],
      hasLiaison: false,
      place: null
    };
  },
  watch: {
    mustSeeExperience: function(value) {
      if (value) {
        return (this.data.tags = ["signature"]);
      }

      this.data.tags = null;
    }
  },
  validations: {
    data: {
      name: { required },
      catchphrase: { required },
      description: { required },
      title: { required },
      activity_id: { required },
      location_id: { required },
      rawLocation: { required },
      contact_name: { required },
      contact_phone_number: {
        requiredIf: function(value) {
          return (
            this.data.contact_name === null || this.data.contact_name === ""
          );
        }
      }
    }
  },

  mounted() {
    this.setFormURLFromModelType();

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
      .catch(err => {});
  },

  methods: {
    handleFormSubmit() {
      this.isLoading = true;
      window.location = this.target_url;
    },

    locationUpdated(location) {
      this.data.lat = location.lat;
      this.data.lng = location.lng;
    },

    uploadCarouselImages() {
      return this.uploadImages("carousel");
    },

    uploadBackgroundImages() {
      return this.uploadImages("background");
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

    setFormURLFromModelType() {
      if (this.type === "activity") {
        return (this.target_url = "/activities");
      }

      if (this.type === "location") {
        return (this.target_url = "/locations");
      }

      if (this.type === "experience") {
        return (this.target_url = "/experiences");
      }
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

            if (this.type == "location") {
              this.initialPosition = {
                lat: response.data.data.lat,
                lng: response.data.data.lng
              };
            }

            if (this.type == "experience") {
              this.selectedLocation = {
                id: response.data.data.location.id,
                name: response.data.data.location.name
              };
              this.selectedActivity = {
                id: response.data.data.activity.id,
                name: response.data.data.activity.name
              };
              this.data.location_id = this.selectedLocation.id;
              this.data.activity_id = this.selectedActivity.id;
              this.data.contact_name = response.data.data.liaison.name;
              this.data.contact_phone_number =
                response.data.data.liaison.phone_number;

              this.mustSeeExperience = response.data.data.tags.length
                ? true
                : false;
            }

            // carousel images are available on all resources
            this.carouselImages = response.data.data.carousel.map(item => ({
              id: item.id,
              src: item.file_path,
              alt: item.description
            }));

            // we have background images on all resources except experiences
            if (this.type != "experience") {
              this.backgroundImages = response.data.data.background.map(
                item => ({
                  id: item.id,
                  src: item.file_path,
                  alt: item.description
                })
              );
            }
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
          return true;
        })
        .catch(error => {
          this.processErrorResponse(error);
        });
    },

    onCancel() {},

    onSelectMultipleImage(images) {
      this.selectedImages = images;
    },

    deleteSelectedImages() {
      this.selectedImages.map(item => {
        axios
          .delete("/media/" + item.id)
          .then(res => {
            this.isLoading = false;
            this.carouselImages = this.carouselImages.filter(
              a => a.id != item.id
            );
            this.backgroundImages = this.backgroundImages.filter(
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
    },

    handleImageRemoved(value) {
      this.imageFiles = this.imageFiles.filter(f => {
        return f.id !== value.id;
      });
    },

    handleDescriptionChanged(value) {
      this.imageFiles = this.imageFiles.map(f => {
        if (f.id === value.id) {
          f.description = value.description;
        }

        return f;
      });
    },

    /**
     * Validate the request data. This validation is handled based on whether the
     * resource in question is an activity or a location resource item
     */
    validateAsync() {
      let validData =
        !this.$v.data.name.$invalid &&
        !this.$v.data.catchphrase.$invalid &&
        !this.$v.data.description.$invalid;

      // We need to change validation scheme if we're working with a tourist experience
      // the other resources have the same structure to them
      if (this.type == "experience") {
        validData =
          !this.$v.data.activity_id.$invalid &&
          !this.$v.data.location_id.$invalid &&
          !this.$v.data.description.$invalid;
      }

      if (!validData) {
        this.$notify({
          group: "articles",
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

    setLocationId(value) {
      this.data.location_id = value.id;
    },

    setActivityId(value) {
      this.data.activity_id = value.id;
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
