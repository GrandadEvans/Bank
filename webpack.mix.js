const mix = require('laravel-mix');

mix
    .js('resources/js/app.js', 'public/js')
    .extract([
        '@fortawesome/fontawesome-svg-core',
        '@fortawesome/free-brands-svg-icons',
        '@fortawesome/free-regular-svg-icons',
        '@fortawesome/free-solid-svg-icons',
        '@fortawesome/vue-fontawesome',
        'axios',
        // 'babel-core',
        'bootstrap-reboot',
        'bootstrap',
        'vue-google-charts',
        // 'babel-loader',
        'currency.js',
        // 'jquery',
        'laravel-echo',
        // 'laravel-mix',
        'lodash',
        'moment',
        'popper.js',
        'pusher-js',
        // 'style-loader',
        'vue',
        'vue-google-charts',
        // 'vue-loader',
        'vue-sweetalert2',
        'vuex'
    ], 'public/js/vendor.js')
    .vue()
    .sass('resources/sass/sass.scss', 'public/css/app.css')
    // .postCss('resources/tmp/app.css', 'public/css/')
    .sass('resources/sass/vendor.scss', 'public/css/vendor.css')
    .copy('resources/images', 'public/images')
    .sourceMaps()
    .webpackConfig({
        module: {
            rules: [
                {
                    test: /\.m?js$/,
                    exclude: /node_modules/,
                    use: {loader: "babel-loader"}
                }
            ]
        }
    });
