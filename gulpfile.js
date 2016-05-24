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

elixir(function(mix) {
    mix
    	.copy('node_modules/bootstrap-select/dist/js/bootstrap-select.js','public/js/vendor/bootstrap-select.js')
    	.copy('node_modules/bootstrap-select/dist/css/bootstrap-select.css','public/css/vendor/bootstrap-select.css')
        .sass('app.scss')
        .browserify('index.js');
});
