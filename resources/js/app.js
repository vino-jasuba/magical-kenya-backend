require('./bootstrap');
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
import 'vue-loading-overlay/dist/vue-loading.css';
import VueFormWizard from 'vue-form-wizard'
import CKEditor from '@ckeditor/ckeditor5-vue';
import VuePlaceAutocomplete from 'vue-place-autocomplete';
import Loading from 'vue-loading-overlay';
import Vuelidate from 'vuelidate'
import Notifications from 'vue-notification'

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

Vue.component('loading', Loading);

Vue.use( CKEditor );

Vue.use(VueFormWizard)

Vue.use(VuePlaceAutocomplete);

Vue.use(Notifications)

Vue.use(Vuelidate)

const app = new Vue({
    el: '#app',
});
