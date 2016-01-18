var elixir = require('laravel-elixir');
require('laravel-elixir-vueify');
require('vue-strap');

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

elixir(function(mix) {

    //mix.livereload();
    mix.sass('app.scss'); //.coffee()
    /*
    mix.sass("app.scss", 'public/css/', {includePaths: [paths.bootstrap + 'stylesheets/']})
        .copy(paths.bootstrap + 'fonts/bootstrap/**', 'public/fonts')
        .scripts([
            'bootstrap.js',
        ], 'public/js/bootstrap.js', 'node_modules/bootstrap-sass/assets/javascripts');
/*
    mix
*/
    mix.browserify('main.js');
    //mix.vueify('main.js', {insertGlobals: true, transform: "vueify", output: "public/js"});

});
