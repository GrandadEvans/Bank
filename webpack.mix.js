// const {VueLoaderPlugin} = require('vue-loader');
const mix = require('laravel-mix');
// webpack.config.js
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
    ], 'public/js/vendor.js')
    .sass('resources/sass/sass.scss', 'public/css/app.css')
    // .postCss('resources/tmp/app.css', 'public/css/')
    .sass('resources/sass/vendor.scss', 'public/css/vendor.css')
    .copy('resources/images', 'public/images')
    .sourceMaps()
;
