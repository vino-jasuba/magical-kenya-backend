require('./bootstrap');
import VueFormWizard from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
import CKEditor from '@ckeditor/ckeditor5-vue';

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

Vue.use( CKEditor );

Vue.use(VueFormWizard)


const app = new Vue({
    el: '#app'
});
