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
        datePickInputClasses: {
            class: 'form-control'
        },
        customerForm: new Form({
            name: '',
            email: '',
            phone_no: '',
            status : 1,
        })
    },
    mounted (){
        this.fetchCampaigns(window.id);
    },
    methods: {
        fetchCampaigns(id) {
            const self = this;
            axios.get('/fetch-customer/'+id)
                    .then(response => {
                        self.customerForm.email = response.data.email;
                        self.customerForm.phone_no = response.data.phone_no;
                        self.customerForm.name = response.data.name;
                        self.customerForm.status = response.data.status;
                        window.facebook_campaign_id = response.data.facebook_campaign_id;
                        return response;
                    });
        },
        saveCustomer: function (id) {
            this.loading = true;
            this.customerForm
                .post('/update-customer/'+id)
                .then((response) => {
                    this.loading = false;
                    this.$swal({
                        title: 'Customer Updated!',
                        type: 'success',
                        allowOutsideClick: false
                    }).then((response) => {
                        window.location.href = '/view-recipients/'+window.facebook_campaign_id;
                    });
                })
                .catch(e => {
                    window.PmEvent.fire('errors.api', getRequestError(e));
                    this.loading = false;
                });
        }
    }
});
