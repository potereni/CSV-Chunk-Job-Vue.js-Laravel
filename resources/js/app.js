require('./bootstrap');

import Vue from 'vue';
import UploadForm from './components/UploadForm.vue';
import UploadResults from './components/UploadResults.vue';


const apps = new Vue({
    el: '#apps',
    components: {
        UploadForm,
        UploadResults,
    }
});