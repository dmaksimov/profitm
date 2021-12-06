import Vue from 'vue';
import '../../common';
import Form from '../../common/form';
import {generateRoute} from '../../common/helpers';
import { ToggleButton } from 'vue-js-toggle-button'
import {getRequestError} from "../../common/helpers";
import InputTag from 'vue-input-tag'
Vue.component('input-tag', InputTag)
 
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
        'input-errors': require('./../../components/input-errors/input-errors').default,
        'spinner-icon': require('./../../components/spinner-icon/spinner-icon').default,
        ToggleButton,
        InputTag
    },
    data: {
        industryTypeIndex: '',
        createFormUrl: null,
        createForm: new Form({
            title: '',
            status: true,
           
        }),
        fieldsSelected : "",
        dbFields : [],
        templateForm : new Form({
            fields : [],
            dbFields : window.defaultFields,
        }),
        isLoading: false,
    },
    mounted() {
        this.createFormUrl = window.createUrl;
        this.industryTypeIndex = window.indexUrl;
        this.dbFields = window.dbfields;
    },
    methods: {
        saveIndustryType() {
            this.isLoading = true;
            this.createForm.post(this.createFormUrl)
                .then(() => {
                    this.isLoading = false;
                    this.$swal({
                        title: 'Industry Type Added!',
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
        saveTemplate() {
            this.isLoading = true;
            this.templateForm.post('/industry-template/'+window.id)
                .then(() => {
                    this.isLoading = false;
                    this.$swal({
                        title: 'Template PM Fields Added!',
                        type: 'success'
                    }).then(() => {
                        window.location.replace(this.industryTypeIndex);
                    });
                })
                .catch(e => {
                    window.PmEvent.fire('errors.api', getRequestError(e));
                    this.isLoading = false;
                });
        }
    },
});
