/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.scss');

require('bootstrap');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
var $ = require('jquery');
window.$ = $;
window.jQuery = $;

require('babel-polyfill');

require('startbootstrap-sb-admin/js/sb-admin');
require('select2');
require('datatables.net-bs4');
require('jquery.easing');
require('bootstrap-multiselect');
require('jquery-ui');
require('layui-src/build/layui');
require('@dashboardcode/bsmultiselect');
let select_roles = require('./role_select');

const imagesContext = require.context('../images', true, /\.(png|jpg|jpeg|gif|ico|svg|webp)$/);
imagesContext.keys().forEach(imagesContext);


$(document).ready(function () {
    console.log('Hello Webpack Encore! Edit me in assets/js/app.js');
    select_roles.render_user_select();
    const array = [1, 2, 3, null];
    if (array.indexOf(3) >= 0) {
        console.log(true);
    }
});