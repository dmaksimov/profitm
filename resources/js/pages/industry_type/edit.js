import Vue from 'vue';
import '../../common';
import Form from '../../common/form';
import {generateRoute} from '../../common/helpers';
import { ToggleButton } from 'vue-js-toggle-button'
import {getRequestError} from "../../common/helpers";
// Wizard
import VueFormWizard from 'vue-form-wizard';
Vue.use(VueFormWizard);
// Validation
import Vuelidate from 'vuelidate';
Vue.use(Vuelidate);
Vue.use(ToggleButton);
// Custom Validation
import { helpers, required, minLength, url } from 'vuelidate/lib/validators';
import { isNorthAmericanPhoneNumber, isCanadianPostalCode, isUnitedStatesPostalCode, looseAddressMatch } from '../../common/validators';

window['app'] = new Vue({
    el: '#app',
    components: {
        'spinner-icon': require('./../../components/spinner-icon/spinner-icon').default,
        ToggleButton,
    },
    data: {
        industryTypeIndex: '',
        createFormUrl: null,
        createForm: new Form({
            title: window.title,
            status: window.status == 1 ? true : false,
           
        }),
        isLoading: false,
    },
    mounted (){
        this.createFormUrl = window.createUrl;
        this.editFormUrl = window.editUrl;
        this.industryTypeIndex = window.indexUrl;
        },
    methods: {
        saveIndustryType(id) {
            this.isLoading = false;
            this.createForm
            .post('/update-industrytype/'+id)
                .then(() => {
                    this.isLoading = false;
                    this.$swal({
                        title: 'Industry Type Updated!',
                        type: 'success'
                    }).then(() => {
                        window.location.replace(this.industryTypeIndex);
                    });
                })
                .catch(e => {
                    window.PmEvent.fire('errors.api', getRequestError(e));
                    this.isLoading = false;
                });
        },
    },
});
