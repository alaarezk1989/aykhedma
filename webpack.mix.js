const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.styles([
    'public/assets/css/icons.css',
    'public/assets/plugins/bootstrap/css/bootstrap.min.css',
    'public/assets/css/admin.css',
    'public/assets/plugins/scroll-bar/jquery.mCustomScrollbar.css',
    'public/assets/plugins/toggle-menu/sidemenu.css',
    'public/assets/plugins/morris/morris.css',
    'public/assets/plugins/select2/select2.css',
    'public/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css',
    'public/assets/plugins/iCheck/flat/_all.css',
    'public/assets/plugins/sumoselect/sumoselect.css',
    'public/assets/css/toastr.min.css',
    'public/assets/css/jquery.timepicker.min.css'
], 'public/assets/css/admin.app.css');

mix.js('resources/js/app.js', 'public/assets/js/vue.app.js');

mix.scripts([
    'public/assets/js/jquery.min.js',
    'public/assets/js/popper.js',
    'public/assets/plugins/bootstrap/js/bootstrap.min.js',
    'public/assets/js/tooltip.js',
    'public/assets/plugins/rating/jquery.rating-stars.js',
    'public/assets/plugins/nicescroll/jquery.nicescroll.min.js',
    'public/assets/plugins/scroll-up-bar/dist/scroll-up-bar.min.js',
    'public/assets/plugins/toggle-menu/sidemenu.js',
    'public/assets/plugins/othercharts/jquery.knob.js',
    'public/assets/plugins/othercharts/jquery.sparkline.min.js',
    'public/assets/plugins/Chart.js/dist/Chart.min.js',
    'public/assets/plugins/Chart.js/dist/Chart.extension.js',
    'public/assets/plugins/morris/morris.min.js',
    'public/assets/plugins/morris/raphael.min.js',
    'public/assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js',
    'public/assets/js/dashboard2.js',
    'public/assets/js/jquery.showmore.js',
    'public/assets/js/sparkline.js',
    'public/assets/js/othercharts.js',
    'public/assets/plugins/select2/select2.full.js',
    'public/assets/plugins/inputmask/jquery.inputmask.js',
    'public/assets/plugins/moment/moment.min.js',
    'public/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js',
    'public/assets/plugins/iCheck/icheck.min.js',
    'public/assets/js/forms.js',
    'public/assets/js/scripts.js',
    'public/assets/plugins/sumoselect/jquery.sumoselect.js',
    'public/assets/js/tree view.js',
    'node_modules/vue/dist/vue.js',
    'public/assets/js/toastr.min.js',
    'public/assets/js/jquery.timepicker.min.js',
    'public/assets/js/googleMap.js',
], 'public/assets/js/admin.app.js');

mix.styles([
    'public/assets/css/bootstrap.min.css',
    'public/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css',
    'public/assets/css/style.css'
], 'public/assets/css/web.app.css');

mix.scripts([
    'public/assets/js/jquery.min.js',
    'public/assets/js/popper.js',
    'public/assets/js/bootstrap.min.js',
    'public/assets/js/owl.carousel.min.js',
    'public/assets/plugins/inputmask/jquery.inputmask.js',
    'public/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js',
    'public/assets/js/main.js',
    'public/assets/js/vue.app.js'
], 'public/assets/js/web.app.js');

