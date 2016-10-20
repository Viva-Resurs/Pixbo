var elixir = require('laravel-elixir');
require('laravel-elixir-vueify');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir.config.js.browserify.options.debug=true;

elixir(function(mix) {
    /* PixboPlayer */
    mix
        .sass('PixboPlayer.scss')
        .scripts(
            [
                'jquery-2.1.3.min.js',
                'vegas.min.js',
                'jquery.ticker.js',
                '../PixboPlayer/*.js',
                '../PixboPlayer/*/*.js'
            ],
            'public/js/PixboPlayer.js',
            'resources/assets/js/vendor'
        );

    /* Fonts */
    mix
        .copy( 'resources/assets/fonts', 'public/fonts' )

    /* Admin GUI */
    mix
        .sass('app.scss')
        .scripts(
            [
                'jquery-2.1.4.min.js',
                '../../../../node_modules/moment/min/moment-with-locales.min.js',
                '../../../../node_modules/bootstrap-select/dist/js/bootstrap-select.js',
                'bootstrap-datetimepicker.min.js',
                'dropzone.js'
            ],
            'public/js/vendor.js',
            'resources/assets/js/vendor'
            
        )
        .browserify('index.js');
});