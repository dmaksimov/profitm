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

window['app'] = new Vue({
    el: '#events-index',
    components: {
        'spinner-icon': require('./../../components/spinner-icon/spinner-icon').default,
    },
    data() {
        return {
            events: [],
          }
    },
    mounted (){
        this.fetchEvents();
    },
    methods : {
        fetchEvents() {
            const self = this;
            axios.get('/fetch-events')
                    .then(response => {
                        self.events = response.data;
                        return response;
                    });
        }
    }
});
