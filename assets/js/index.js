import('../styles/style.scss');
import('bootstrap');
require('./plugins/showBlogs');

const $ = require('jquery');
global.$ = $;

const helper = require('./helper');
global.helper = helper;

$(document).ready(function() {
    helper.ajaxSubmitForm();
    $('.showBlogs').showBlogs();
});
