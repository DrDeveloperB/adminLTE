require('./bootstrap');

try {
    window.$ = window.jQuery = require('admin-lte/plugins/jquery/jquery.min');

    require('admin-lte');
} catch (e) {}
