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
import JsonCSV from 'vue-json-csv'

Vue.component('downloadCsv', JsonCSV)

Vue.use(VueChartkick, {adapter: Chart});

window['app'] = new Vue({
    el: '#campaign-index',
    components: {
        'fb-campaign': require('./../../components/campaign/FbCampaign').default,
        'pm-pagination': require('./../../components/pm-pagination/pm-pagination').default,
        'spinner-icon': require('./../../components/spinner-icon/spinner-icon').default,
    },
    data: {
        isLoading: false,
        campaign: {},
        campaigns: [],
        companies: [],
        companySelected: null,
        industrySelected: null,
        industries : null,
        searchForm: new Form({
            company: localStorage.getItem('campaignsIndexCompany') ? JSON.parse(localStorage.getItem('campaignsIndexCompany')) : undefined,
            industry: localStorage.getItem('campaignsIndexIndustry') ? JSON.parse(localStorage.getItem('campaignsIndexIndustry')) : undefined,
            q: localStorage.getItem('campaignsIndexQ'),
        }),
    },
    mounted (){
        this.fetchCampaigns();
        axios
            .get(window.getCompanyUrl, {
                headers: {
                    'Content-Type': 'application/json'
                },
                params: {
                    per_page: 100
                },
                data: null
            })
            .then(response => {
                this.companies = response.data.data;
            });
        this.industries = window.industries;
    },
    methods : {
        onCompanySelected() {
            this.searchForm.page = 1;
            return this.fetchData();
        },
        fetchData() {
            const self = this;
            if (this.companySelected) {
                localStorage.setItem('campaignsIndexCompany', JSON.stringify(this.companySelected));
                this.searchForm.company = this.companySelected.id;
            } else {
                this.searchForm.company = null;
                localStorage.removeItem('campaignsIndexCompany');
            }
            if (this.searchForm.q) {
                localStorage.setItem('campaignsIndexQ', this.searchForm.q);
            } else {
                localStorage.removeItem('campaignsIndexQ');
            }
            if (this.industrySelected) {
                localStorage.setItem('campaignsIndexIndustry',JSON.stringify(this.industrySelected));
                this.searchForm.industry = this.industrySelected.id;
            } else {
                this.searchForm.industry = null;
                localStorage.removeItem('campaignsIndexIndustry');
            }
            this.isLoading = true;
            this.searchForm.get('/fetch-campaigns')
                .then(response => {
                    console.log(response);
                    self.campaign = response;
                    self.campaigns = response;
                    this.isLoading = false;
                })
                .catch(error => {
                    window.PmEvent.fire('errors.api', "Unable to get campaigns");
                });
        },
        fetchCampaigns() {
            const self = this;
            axios.get('/fetch-campaigns')
                    .then(response => {
                        self.campaign = response.data;
                        self.campaigns = response.data;
                        return response;
                    });
        }
    }
});
