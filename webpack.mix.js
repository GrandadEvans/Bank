const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
    .vue()
    .js('resources/js/app.js', 'public/js')
    .extract([
        'axios',
        'lodash',
        'currency.js',
        'vue',
        'vue-sweetalert',
        'moment',
        'daterangepicker',
        'toastify-js'
    ])
    .sass('resources/sass/sass.scss', 'resources/to_delete/app.css')
    .sass('resources/sass/vendor.scss', 'public/css/vendor.css')
    .postCss('resources/to_delete/app.css', 'public/css/')
    .copy('resources/images', 'public/images')
    .sourceMaps()
;
