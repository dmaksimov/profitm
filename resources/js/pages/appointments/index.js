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
import FullCalendar from './../../components/vue-full-calendar'
import 'fullcalendar/dist/fullcalendar.css'

Vue.use(FullCalendar);

Vue.use(VueChartkick, {adapter: Chart});

window['app'] = new Vue({
    el: '#user-index',
    components: {
        'appointment': require('./../../components/appointments/Appointment').default,
        'pm-pagination': require('./../../components/pm-pagination/pm-pagination').default,
        'spinner-icon': require('./../../components/spinner-icon/spinner-icon').default,
    },
    data: {
        isLoading: false,
        appointment: {},
        appointments: [],
        events: [],
    },
    mounted (){
        this.fetchAppointments(window.id);
    },
    methods : {
        fetchAppointments(id) {
            const self = this;
            axios.get('/fetch-appointments/'+id)
                    .then(response => {
                        self.appointment = response.data.appointments;
                        self.appointments = response.data.appointments;
                        self.events = response.data.events;
                        return response;
                    });
        },
        scrollDown(){
            document.querySelector('#listngs-view').scrollIntoView({ behavior: 'smooth' });
        }
    }
});
