require('./bootstrap');
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
import 'vue-loading-overlay/dist/vue-loading.css';
import 'vue-select/dist/vue-select.css';
import 'vue-select-image/dist/vue-select-image.css';
import 'vue-datetime/dist/vue-datetime.css'
import VueFormWizard from 'vue-form-wizard'
import CKEditor from '@ckeditor/ckeditor5-vue';
import Loading from 'vue-loading-overlay';
import Vuelidate from 'vuelidate'
import Notifications from 'vue-notification'
import vSelect from 'vue-select'
import VueSelectImage from 'vue-select-image'
import { Datetime } from 'vue-datetime'
import * as VueGoogleMaps from 'vue2-google-maps'

window.Vue = require ('vue');

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);

Vue.component(
    'activity',
    require('./components/Article.vue').default
);

Vue.component(
    'activity-list',
    require('./components/ArticleList.vue').default
);

Vue.component(
    'activities-crud',
    require('./components/CreateUpdateArticle.vue').default
);

Vue.component(
    'image-upload',
    require('./components/ImageUpload.vue').default
);

Vue.component(
    'image-upload-with-description',
    require('./components/ImagePreview.vue').default
);

Vue.component(
    'events',
    require('./components/Events.vue').default
);

Vue.component(
    'event-crud',
    require('./components/CreateUpdateEvent.vue').default
);

Vue.component(
    'generic-modal',
    require('./components/GenericDeleteModal.vue').default
);

Vue.component(
    'custom-gmap-autocomplete',
    require('./components/GmapAutoComplete.vue').default
);

Vue.component('loading', Loading);

Vue.component('v-select', vSelect);

Vue.component('datetime', Datetime);

Vue.use( CKEditor );

Vue.use(VueFormWizard);

Vue.use(Notifications);

Vue.use(Vuelidate);

Vue.use(VueSelectImage);

Vue.use(VueGoogleMaps, {
  load: {
    key: 'AIzaSyBngEzW0FoQzqYsB-ENmCyOjY_VvTlz4ig',
    libraries: 'places',
  },
  installComponents: true
});

const app = new Vue({
    el: '#app',
});
