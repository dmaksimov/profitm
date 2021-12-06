import Vue from 'vue';
import './../../common';
import axios from 'axios';
import Form from './../../common/form';
import {generateRoute} from './../../common/helpers'
import {getRequestError} from "../../common/helpers";

window['app'] = new Vue({
    el: '#company-index',
    components: {
        'pm-pagination': require('./../../components/pm-pagination/pm-pagination').default,
        'spinner-icon': require('./../../components/spinner-icon/spinner-icon').default,
    },
    computed: {
        pagination: function () {
            return {
                page: this.searchForm.page,
                per_page: this.searchForm.per_page,
                total: this.total
            };
        }
    },
    data: {
        searchFormUrl: null,
        searchForm: new Form({
            industryType: null,
            q: null,
            page: 1,
            per_page: 15,
        }),
        industryTypeEdit: '',
        industryTypeDelete: '',
        isLoading: true,
        total: null,
        industry_types: [],
        searchTerm: '',
        industryTypeSelected: null,
        columnData: [
            {
                slot: 'id',
            },  {
                field: 'url'
            }
        ],
        tableOptions: {
            mobile: 'lg'
        },
        formUrl: ''
    },
    mounted() {
        this.searchFormUrl = window.searchFormUrl;
        this.searchForm.q = window.q;
        this.industryTypeEdit = window.industryTypeEdit;
        this.industryTypeDelete = window.industryTypeDelete;

        this.fetchData();
    },
    methods: {
        generateRoute,
        onIndustryTypeSelected() {
            this.searchForm.page = 1;
            return this.fetchData();
        },
        fetchData() {
            this.isLoading = true;
            this.searchForm.get(this.searchFormUrl)
                .then(response => {
                    this.industry_types = response.data;
                    this.searchForm.page = response.meta.current_page;
                    this.searchForm.per_page = response.meta.per_page;
                    this.total= response.meta.total;
                    this.isLoading = false;
                })
                .catch(error => {
                    console.log(error);
                    window.PmEvent.fire('errors.api', "Unable to get Industry Type");
                });
        },
        deleteIndustryType: function (id, index) {
            var route = generateRoute(this.industryTypeDelete, {industryTypeId: id});
            this.$swal({
                title: "Are you sure?",
                text: "You will not be able to undo this operation!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                allowOutsideClick: false,
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    console.log(route);
                    return axios.delete(route);
                }
            }).then(result => {
                if (result.value) {
                    this.$toastr.success("IndustryType deleted");
                    this.industry_types.splice(index, 1);
                }
            }).catch(error  => {
                window.PmEvent.fire('errors.api', getRequestError(error));
                this.isLoading = false;
            });
        },
        // onPageChanged(event) {
        //     this.searchForm.page = event.page;
        //     return this.fetchData();
        // }
    }
});
