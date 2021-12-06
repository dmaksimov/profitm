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
        customers: null,
        customerSelected : null,
        customerForm: new Form({
            name: '',
            email: '',
            phone_no: '',
            date: '',
            start_time : "10:00:00",
            end_time : "12:00:00",
            facebook_campaign_id:'',
            customer_id : '',
            cid : '',
        })
    },
    mounted () {
        this.customers = window.customers;
    },
    methods: {
        saveNewCustomer: function (id) {
            this.loading = true;
            this.customerForm.facebook_campaign_id = id;
            console.log(this.customerForm);
            this.customerForm
                .post('/create-recipients/'+id)
                .then((request) => {
                    this.loading = false;
                    this.$swal({
                        title: 'Recipients Created!',
                        type: 'success',
                        allowOutsideClick: false
                    }).then(() => {
                        window.location.href = '/view-recipients/'+id;
                    });
                })
                .catch(e => {
                    window.PmEvent.fire('errors.api', getRequestError(e));
                    this.loading = false;
                });
        },
        saveCustomer: function (id) {
            this.loading = true;
            this.customerForm.facebook_campaign_id = id;
            if(this.customerSelected)
            {
                this.customerForm.customer_id = this.customerSelected.id || null;
            }
            this.customerForm.cid = window.cid;
            console.log(this.customerForm);
            this.customerForm
                .post('/add-appointment/'+id)
                .then((request) => {
                    this.loading = false;
                    this.$swal({
                        title: 'Appointment Created!',
                        type: 'success',
                        allowOutsideClick: false
                    }).then(() => {
                        window.location.href = '/view-appointments/'+id;
                    });
                })
                .catch(e => {
                    window.PmEvent.fire('errors.api', getRequestError(e));
                    this.loading = false;
                });
        }
    }
});
