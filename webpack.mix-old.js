const mix = require('laravel-mix');

mix
    // js([
            // 'node_modules/axios/dist/axios.js',
            // 'node_modules/jquery/dist/jquery.js',
            // 'node_modules/bootstrap/dist/js/bootstrap.js',
            // 'node_modules/vue/dist/vue.js',
            // 'node_modules/moment/moment.js',
            // 'node_modules/currency.js/dist/currency.js',
            // 'node_modules/datatables.net/js/jquery.dataTables.js',
            // 'node_modules/datatables.net-bs4/js/dataTables.bootstrap4.js',
            // 'node_modules/sweetalert2/dist/sweetalert2.js'
        // ], 'public/js/vendor.js')
    .js('resources/js/app.js', 'public/js')
    // .sass('resources/sass/sass.scss',    'public/css')
    // .sass('resources/sass/vendor.scss', 'public/css/vendor.css')
    // .autoload({
    //     jquery: ['$', 'window.jQuery'],
    //     moment: ['window.moment', 'moment'],
    //     axios: ['axios']
    // })
    // .browserSync({
    //     proxy: 'http://bank.dev',
    //     notify: true,
    //     open: false
    // })
    .sourceMaps()
    // .copy('resources/images', 'public/images')
    .vue();
