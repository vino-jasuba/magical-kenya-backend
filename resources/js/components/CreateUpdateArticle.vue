<style scoped>
    .action-link {
        cursor: pointer;
    }
</style>

<template>
    <div class="card-body">
        <loading :active="isLoading"
            :can-cancel="true"
            :on-cancel="onCancel"
            :is-full-page="fullPage">
        </loading>
        <notifications group="articles"/>
        <form-wizard color="#5e72e4" title="" subtitle="" stepSize="xs" @on-complete="handleFormSubmit">
            <tab-content class="mt-6" title="Create Activity" :before-change="validateAsync">
                <div class="form-group row text-right">
                    <label class="form-control-label col-2" for="name">Name</label>
                    <input class="form-control col-8" ref="nameInput" :class="{'is-invalid': $v.data.name.$error}" v-model.trim="$v.data.name.$model" type="text" name="name" id="name">
                </div>
                <div class="form-group row text-right">
                    <label class="form-control-label col-2" for="catchphrase">Catchphrase</label>
                    <input class="form-control col-8" :class="{'is-invalid': $v.data.catchphrase.$error}" v-model.trim="$v.data.catchphrase.$model" type="text" name="catchphrase" id="catchphrase">
                </div>
                <div class="form-group row text-right">
                    <label class="form-control-label col-2">Color Tag</label>
                    <swatches v-model="data.color_tag" color="material-light"></swatches>
                </div>
                <div v-if="type === 'location'" class="form-group row text-right">
                    <label for="location" class="form-control-label col-2">Location</label>
                    <place-autocomplete-field class="col-8"
                        v-model="rawLocation"
                        placeholder="Enter an an address, zipcode, or location"
                        name="rawLocation"
                        api-key="AIzaSyCbr2jFV2MbmT7QxP5eUVHywrEG2TUfnDM">
                    </place-autocomplete-field>
                </div>
                <div class="form-group row text-right">
                    <label class="form-control-label col-2" for="description">Description</label>
                    <ckeditor class="col-8" :editor="editor" v-model="$v.data.description.$model" :config="editorConfig"></ckeditor>
                </div>
            </tab-content>
            <tab-content title="Select Images" :before-change="validateImages">
                <div class="form-group row text-right">
                    <image-upload
                        :imageIdentifier="imageUniqId"
                        v-for="index in Object.keys(imageFiles).length + 1"
                        :key="index"
                        @imageSelected="handleSelectedImage"
                        @imageRemoved="handleImageRemoved"
                    >
                    </image-upload>
                </div>
                <button class="btn btn-primary" @click="addImageUploadField">Add Image</button>
            </tab-content>
            <tab-content title="Upload">
                Upload media files
            </tab-content>
        </form-wizard>
    </div>
</template>

<script>
    import "vue-swatches/dist/vue-swatches.min.css";
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
    import Cookie from 'js-cookie';
    import Swatches from 'vue-swatches';
    import uuid from 'uuid/v4';
    import { required } from 'vuelidate/lib/validators'

    export default {
        props: ['slug','type'],
        components: { Swatches },
        data() {
            return {
                data: {
                    name: null,
                    catchphrase: null,
                    description: null,
                    icon: '/path/to/icon/file',
                    lat: 12.12,
                    lng: 92.134,
                    carousel: [],
                    background: [],
                    color_tag: '#1CA085',
                },
                editor: ClassicEditor,
                editorConfig: {
                    toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],
                },
                target_url: null,
                isEditing: false,
                rawLocation: null,
                imageFiles: {},
                isLoading: true,
                fullPage: true,
                imageUniqId: uuid(),
                loadingWizard: true,
            };
        },

        validations: {
            data: {
                name: { required },
                catchphrase: { required },
                description: { required },
            }
        },

        mounted() {
            this.setFormURLFromModelType();

            this.editContextFetchRecord();
        },

        methods: {
            handleFormSubmit() {
                /** Upload images for the created resource */
                const use_case = 'carousel';

                let formData = new FormData;
                formData.set('target_key', this.data.data.id);
                formData.set('target_type', this.type);
                formData.set('use_case', use_case);

                const images = Object.values(this.imageFiles);

                for (let i = 0; i < images.length; i++) {
                    formData.append(`files[${i}]`, images[i].file);
                    formData.append(`description[${i}]`, images[i].description);
                }

                axios.post('/media', formData).then(res => {
                    window.location = this.target_url;
                }).catch(err => {
                    console.log({...err.response.data})
                })
            },

            setFormURLFromModelType() {
                if (this.type === "activity") {
                    this.target_url = "/activities"
                }

                if (this.type === "location") {
                    this.target_url = "/locations"
                }
            },

            editContextFetchRecord() {
            // If we have a slug then we're in edit context therefore
            // we need to fetch the associated record
                if (this.slug) {
                    this.isEditing = true;
                    axios.get(`${this.target_url}/` + this.slug).then(response => {
                        this.data = {...response.data.data}
                    }).catch(error => {
                        console.log({...error.response.data});
                    })
                }

                this.isLoading = false;
            },

            updateRecordRequest() {
                return axios.patch(`${this.target_url}/` + this.data.slug, {
                    ...this.data,
                    headers: {
                        Authorization: 'Bearer ' + Cookie.get('laravel_token')
                    }
                }).then(res => {
                    this.data = {...res.data};
                    return true;
                }).catch(error => {
                    this.processErrorResponse(error);
                });
            },

            createRecordRequest() {
                return axios.post(this.target_url, {
                    ...this.data,
                    headers: {
                        Authorization: 'Bearer ' + Cookie.get('laravel_token')
                    }
                }).then(res => {
                    this.data = {...res.data};
                    return true;
                }).catch(error => {
                    this.processErrorResponse(error);
                });
            },

            onCancel() {
                console.log("this is funny")
            },

            handleSelectedImage(uploadedFile) {
                this.imageFiles[uploadedFile.id] = uploadedFile;
            },

            handleImageRemoved(imageId) {

            },

            addImageUploadField() {
                this.imageUniqId = uuid();
            },

            /**
             * Validate the request data. This validation is handled based on whether the
             * resource in question is an activity or a location resource item
             */
            validateAsync() {
                const validData = !this.$v.data.name.$invalid && !this.$v.data.catchphrase.$invalid && !this.$v.data.description.$invalid;

                if (!validData) {
                    this.$notify({
                        group: 'articles',
                        title: 'Error',
                        text: 'You cannot proceed without filling all the fields',
                        type: 'error',
                        duration: 5000,
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
                        group: 'articles',
                        title: data.message,
                        text: e[0],
                        type: 'error',
                        duration: 5000,
                    });
                });

                throw error;
            }
        }
    }
</script>
