<template>
    <div class="row no-gutters customer-component active mt-4" :id="'customer-component-' + customer.id" >
        <div class="col-12 col-md-4 col-xl-3">
            <div class="user-row--id justify-content-center justify-content-xl-start">
                <strong class="mr-2">ID: {{ customer.id }}</strong>
                <span class="user-name" v-if="customer.name">{{ customer.name}}</span>
            </div>
        </div>
        <div class="col-12 col-md-2 col-lg-3 col-xl-3">
            <div class="user-row--email justify-content-center justify-content-xl-start">
                <i class="fas fa-envelope mr-2"></i>{{ customer.email || '--' }}
            </div>
        </div>
        <div class="col-12 col-md-2 col-lg-3 col-xl-2">
            <div class="user-row--email justify-content-center justify-content-xl-start">
                <b v-if="customer.status == 1">In Progress</b>
                <b v-if="customer.status == 2">New Appointment</b>
                <b v-if="customer.status == 0">Closed</b>
            </div>
        </div>
        <div class="col-12 col-md-2  col-lg-3 col-xl-2">
            <div class="user-row--phone-number justify-content-center justify-content-xl-start">
                <span class="pm-font-phone-icon mr-2"></span>{{ customer.phone_no || '--' }}
            </div>
        </div>
        <div class="col-12 col-md-2 col-lg-4 col-xl-2">
            <div class="user-row--options justify-content-center align-items-xl-start">
                <a  :href="'/add-appointment/'+customer.facebook_campaign_id+'?cid='+customer.id" class="btn btn-link pm-btn-link pm-btn-link-black" >
                    <span class="fa fa-plus mr-3"></span> Add Appointment
                </a>
                <a  :href="'/edit-recipients/'+customer.id" class="btn btn-link pm-btn-link pm-btn-link-black" >
                    <i class="fas fa-pencil-alt mr-2"></i> Edit Recipients
                </a>
            </div>
        </div>
    </div>
</template>
<script>
    import Vue from 'vue';
    import moment from 'moment';
    import axios from 'axios';
    import {generateRoute} from './../../common/helpers'

    // Chart Library
    import VueChartkick from 'vue-chartkick'
    import Chart from 'chart.js'
    Vue.use(VueChartkick, {adapter: Chart});

    export default {
        components: {
            'b-popover': require('bootstrap-vue/src/components/popover/popover').default,
            'status': require('./../status/status').default,
        },
        props: {
            customer: {
                required: true,
                default: function () {
                    return {};
                }
            }
        },
    }
</script>
