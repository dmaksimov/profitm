import Vue from 'vue';
import './../../common';
import Form from './../../common/form';
import 'vue-toastr-2/dist/vue-toastr-2.min.css'
import axios from 'axios';
// Toastr Library
import VueToastr2 from 'vue-toastr-2'
// Chart Library
import VueChartkick from 'vue-chartkick'
import Chart from 'chart.js'
import {filter} from 'lodash';

Vue.use(VueChartkick, {adapter: Chart});

window['app'] = new Vue({
    el: '#user-index',
    components: {
        'customer': require('./../../components/customer/Customer').default,
        'pm-pagination': require('./../../components/pm-pagination/pm-pagination').default,
        'spinner-icon': require('./../../components/spinner-icon/spinner-icon').default,
    },
    data: {
        isLoading: false,
        customer: {},
        customers: [],
    },
    mounted (){
        console.log(window.id);
        this.fetchCampaigns(window.id);
    },
    methods : {
        fetchCampaigns(id) {
            const self = this;
            axios.get('/fetch-customers/'+id)
                    .then(response => {
                        self.customer = response.data;
                        self.customers = response.data;
                        return response;
                    });
        }
    }
});
