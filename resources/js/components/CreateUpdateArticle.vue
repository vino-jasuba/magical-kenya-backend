<style scoped>
    .action-link {
        cursor: pointer;
    }
</style>

<template>
    <div class="card-body">
        <form-wizard color="#5e72e4" title="" subtitle="" stepSize="xs">
            <tab-content class="mt-6" title="Create Activity">
                <div class="form-group row text-right">
                    <label class="form-control-label col-2" for="name">Name</label>
                    <input class="form-control form-control-alternative col-8" v-model="data.name" type="text" name="name" id="name">
                </div>
                <div class="form-group row text-right">
                    <label class="form-control-label col-2" for="catchphrase">Catchphrase</label>
                    <input class="form-control form-control-alternative col-8" v-model="data.catchphrase" type="text" name="catchphrase" id="catchphrase">
                </div>
                <div class="form-group row text-right">
                    <label class="form-control-label col-2">Color Tag</label>
                    <swatches v-model="data.color_tag" color="material-light"></swatches>
                </div>
                <div v-if="type === 'location'" class="form-group row text-right">
                    <label for="location" class="form-control-label col-2">Location</label>
                    <input class="form-control form-control-alternative col-8" v-model="data.catchphrase" type="text" name="location" id="location">
                </div>
                <div class="form-group row text-right">
                    <label class="form-control-label col-2" for="description">Description</label>
                    <ckeditor class="col-8" :editor="editor" v-model="data.description" :config="editorConfig"></ckeditor>
                </div>
            </tab-content>
            <tab-content title="Select Images">
                <div class="form-group row text-right">
                    <label class="form-control-label col-2" for="background">Background Images</label>

                </div>
            </tab-content>
            <tab-content title="Upload">
                Upload media files
            </tab-content>
        </form-wizard>
    </div>
</template>

<script>
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
    import Cookie from 'js-cookie';
    import Swatches from 'vue-swatches';
    import "vue-swatches/dist/vue-swatches.min.css";

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
                    isEditing: false,
                    carousel: [],
                    background: [],
                    color_tag: '#1CA085',
                },
                editor: ClassicEditor,
                editorConfig: {
                    toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],
                },
                target_url: null,
            };
        },

        mounted() {
            this.setFormURLFromModelType();

            this.editContextFetchRecord();
        },

        methods: {
            handleFormSubmit() {
                if (this.isEditing) {
                    return this.updateRecordRequest();
                }

                this.createRecordRequest();
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
                    this.data.isEditing = true;
                    axios.get(`${this.target_url}/` + this.slug).then(response => {
                        this.data = {...response.data.data}
                        console.log({...response.data});
                    }).catch(error => {
                        console.log({...error.response.data});
                    })
                }
            },

            updateRecordRequest() {
                axios.patch(`${this.target_url}/` + this.data.slug, {
                    ...this.data,
                    headers: {
                        Authorization: 'Bearer ' + Cookie.get('laravel_token')
                    }
                }).then(response => {
                    console.log({...response.data});
                });
            },

            createRecordRequest() {
                axios.post(this.target_url, {
                    ...this.data,
                    headers: {
                        Authorization: 'Bearer ' + Cookie.get('laravel_token')
                    }
                }).then(response => {
                    console.log({...response.data});
                });
            }
        }
    }
</script>
