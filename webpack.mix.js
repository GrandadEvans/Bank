const mix = require('laravel-mix');
// webpack.config.js
const {VueLoaderPlugin} = require('vue-loader')

module.exports = {
    mode: 'development',
    module: {
        rules: [
            {
                test: /\.vue$/,
                loader: 'vue-loader'
            },
            // this will apply to both plain `.js` files
            // AND `<script>` blocks in `.vue` files
            {
                test: /\.js$/,
                loader: 'babel-loader'
            },
            // this will apply to both plain `.css` files
            // AND `<style>` blocks in `.vue` files
            {
                test: /\.css$/,
                use: [
                    'vue-style-loader',
                    'css-loader'
                ]
            }
        ]
    },
    plugins: [
        // make sure to include the plugin for the magic
        new VueLoaderPlugin()
    ]
}
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
    // .copy('resources/images', 'public/images')
    .sourceMaps()
;
