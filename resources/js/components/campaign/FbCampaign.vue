<template>
    <div class="row no-gutters campaign-component active" :id="'campaign-component-' + campaign.id" >
        <div class="col-12 col-md-5">
            <div class="campaign-header" >
                <div class="campaign-header--status"><div class="status-component" no-label=""><span class="status-icon active"></span> <span class="status-value d-none">ACTIVE</span></div></div>
                <div class="campaign-header--title">
                    <p><b>{{ campaign.id || " -- "}}</b> - {{ campaign.dealershipName || " -- " }}</b></p>
                    <p><b>Agency : {{ campaign.agencyName || " --- " }}</b></p>
                </div>

                <div class="campaign-header--dates">
                    <div>
                        <span class="label">Start Date:</span>
                        <span class="value">{{ campaign.start_date| amDateFormat('MM.DD.YY') }}</span>
                    </div>
                    <div v-if="campaign.end_date">
                        <span class="label">End Date:</span>
                        <span class="value">{{ campaign.end_date | amDateFormat('MM.DD.YY') }}</span>
                    </div>
                </div>
            </div>
            <div class="campaign-postcard" v-if="campaign.totalAppointments > 0" >
                <div class="campaign-postcard--image">
                    <pie-chart height="70px" :colors="['#572E8D', '#e7f386', '#67A7CC']" :legend="false" :data="campaign.pieChartData[0]"></pie-chart>
                </div>
                <div class="campaign-postcard--value campaign-chart--labels">
                    <span class="sms">{{campaign.totalAppointments}} Total Appointments</span>
                    <span class="call">{{campaign.finishedAppointments}}  Finished Appointments</span>
                    <span class="email">{{campaign.pendingAppointments}}  Pending Appointments</span>
                </div>
            </div>
            <div class="campaign-postcard justify-content-center" v-else>
                No Appointment Created
            </div>
        </div>
        <div class="col-6 col-md-4 campaign-count" >
            <div class="campaign-count--top">
                <div class="campaign-count--stat">
                    <span class="label">New:</span>
                    <span class="value">{{campaign.newCustomers}}</span>
                </div>
                <div class="campaign-count--stat">
                    <span class="label">Open:</span>
                    <span class="value">{{campaign.openCustomers}}</span>
                </div>
                <div class="campaign-count--stat">
                    <span class="label">Closed:</span>
                    <span class="value">{{campaign.closedCustomers}}</span>
                </div>
            </div>
            <div class="campaign-count--bottom">
                <span class="label">Total Leads:</span>
                <span class="value">{{campaign.totalCustomers}}</span>
            </div>
        </div>
        <div class="col-6 col-md-3 campaign-links">
            <a :href="'assign-companies/'+campaign.id"><span class="fa fa-user-tie"></span> Assign Agency & Company</a>
            <a :href="'view-recipients/'+campaign.id"><span class="fa fa-users"></span> Recipients</a>
            <a :href="'add-appointment/'+campaign.id"><span class="fa fa-plus"></span> Add Appointments</a>
            <a :href="'view-appointments/'+campaign.id"><span class="fas fa-calendar-check"></span> View Appointments</a>
            <div v-if="csvData.length > 0">
                <download-csv :data="csvData" :name="campaign.title"> <a href="javascript:void(0)" ><i class="fa fa-download mr-3" aria-hidden="true"></i>Export As CSV</a></download-csv>
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
            campaign: {
                required: true,
                default: function () {
                    return {};
                }
            },
        },
        data() {
            return {
                csvData : Object.values(this.campaign.csvData),
            }
        },
    }
</script>
