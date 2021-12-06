<template>
    <div class="row no-gutters customer-component active mt-4" :id="'customer-component-' + appointment.id" >
        <div class="col-12 col-md-8 col-xl-3">
            <div class="user-row--id justify-content-center justify-content-xl-start">
                <strong class="mr-2">ID: {{ appointment.id }} {{appointment.customer.name}}</strong>
            </div>
        </div>
        <div class="col-12 col-md-5 col-xl-3">
            <div class="user-row--email justify-content-center justify-content-xl-start">
                <div class="date-section mr-5"><i class="fas fa-calendar-check mr-3"></i><br>{{ appointment.date| amDateFormat('MM.DD.YY') }}</div>
                <div class="time-secton "><i class="fas fa-clock mr-2"></i><br>{{ appointment.start_time| timeFormat('h : mm a') }} - {{ appointment.end_time| timeFormat('h : mm a') }}</div>
            </div>
        </div>
        <div class="col-12 col-md-5 col-lg-4 col-xl-2">
            <div class="user-row--phone-number justify-content-center justify-content-xl-start">
                <span class="fas fa-envelope mr-2"></span>{{appointment.customer.email || "___"}}
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4 col-xl-2">
            <div class="user-row--phone-number justify-content-center justify-content-xl-start">
                <span class="pm-font-phone-icon mr-2"></span>{{appointment.customer.phone_no || "___"}}
            </div>
        </div>
        <div class="col-12 col-lg-4 col-xl-2">
            <div class="user-row--options justify-content-center align-items-xl-start">
                <label for="phone">Update Status</label>
                    <select class="form-control status-update" name="status" v-model="appointment.status" @change="updateStatus($event,appointment.id)">
                        <option value="0">New Appointment</option>
                        <option value="1">Finished Appointment</option>
                        <option value="2">Cancel Appointment</option>
                    </select>
            </div>
        </div>
    </div>
</template>
<script>
    import Vue from 'vue';
    import moment from 'moment';
    import axios from 'axios';
    import Form from "./../../common/form";
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
            appointment: {
                required: true,
                default: function () {
                    return {};
                }
            }
        },
        methods: {
            updateStatus(event,id)
            {
                let data = new Form({
                    id : id,
                    status: event.target.value,
                });
                this.$swal({
                title: "Are you sure?",
                text: "You want to update this appointment status",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                allowOutsideClick: false,
                showLoaderOnConfirm: true,
                preConfirm: () => {
                        return data.post('/update-status');
                    }
                }).then(result => {
                    if (result.value) {
                        this.$swal({
                            title: 'Appointment Status Updated!',
                            type: 'success'
                        });
                    }
                }, error => {
                    window.PmEvent.fire('errors.api', 'Unable to process your request');
                });
            }
        }
    }
</script>
