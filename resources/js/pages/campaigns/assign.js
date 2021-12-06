import Vue from 'vue';
import '../../common';
import Form from '../../common/form';
import '../../filters/user-role.filter';
import VueTimepicker from 'vue2-timepicker'
import 'vue2-timepicker/dist/VueTimepicker.css'
import {getRequestError} from "../../common/helpers";
import moment from 'moment';
import axios from 'axios';
import VueSweetalert2 from 'vue-sweetalert2';
Vue.use(VueSweetalert2);

window['app'] = new Vue({
    el: '#customer-create',
    components: {
        'spinner-icon': require('./../../components/spinner-icon/spinner-icon').default,
        'date-pick': require('./../../components/date-pick/date-pick').default,
        VueTimepicker,
    },
    data: {
        isAdmin: false,
        loading: false,
        agencies: [],
        dealerships: [],
        industries : [],
        agencySelected : window.agencySelected,
        dealershipSelected  : window.dealershipSelected,
        industrySelected : window.industrySelected,
        datePickInputClasses: {
            class: 'form-control'
        },
        assignForm: new Form({
            dealer_id: '',
            agency_id: '',
            industry_type_id: ''
        })
    },
    mounted (){
        this.agencies = window.agencies;
        this.dealerships = window.dealerships;
        this.industries = window.industries;
        this.fetchCampaign(window.id);
    },
    methods: {
        fetchCampaign(id) {
            const self = this;
            axios.get('/fetch-customer/'+id)
                    .then(response => {
                        self.assignForm.dealer_id = response.data.dealer_id;
                        self.assignForm.agency_id = response.data.agency_id;
                        self.assignForm.industry_type_id = response.data.industry_type_id;
                        return response;
                    });
        },
        assignCompanies: function (id) {
            this.loading = true;
            if(this.agencySelected)
            {
                this.assignForm.agency_id = this.agencySelected.id;
            }
            if(this.dealershipSelected)
            {
                this.assignForm.dealer_id = this.dealershipSelected.id || null;
            }
            if(this.industrySelected)
            {
                this.assignForm.industry_type_id = this.industrySelected.id || null;
            }
            this.assignForm
                .post('/assign-companies/'+id)
                .then((response) => {
                    this.loading = false;
                    this.$swal({
                        title: 'Companies Assigned for Campaign',
                        type: 'success',
                        allowOutsideClick: false
                    }).then((response) => {
                        window.location.href = '/facebook-campaigns';
                    });
                })
                .catch(e => {
                    window.PmEvent.fire('errors.api', getRequestError(e));
                    this.loading = false;
                });
        }
    }
});
