import Vue from 'vue';
import moment from 'moment';

Vue.filter('amDateFormat', function (value, format) {
    return moment(value, 'YYYY-MM-DD').format(format);
});

Vue.filter('timeFormat', function (value, format) {
    return moment(value, 'YYYY-MM-DD h:mm:ss').format(format);
});