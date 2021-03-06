var elixir = require('laravel-elixir');

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
    //mix.sass('app.scss');
    mix.sass('ol.scss');
    mix.copy('resources/assets/images/','public/images/');
    mix.copy('resources/assets/css/','public/css/');
    mix.copy('resources/assets/js/marino-scripts','public/js/marino-scripts');
    mix.copy('resources/assets/js/bower_components','public/js');
    mix.copy('resources/assets/js/ol.js','public/js');
    mix.copy('resources/assets/js/notify.js','public/js');

    mix.copy('node_modules/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js','public/js/');
    mix.copy('node_modules/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css','public/css/');
    mix.copy('node_modules/moment/min/moment.min.js','public/js/');

    mix.copy('node_modules/bootstrap-fileinput/js', 'public/bootstrap-fileinput/js');
    mix.copy('node_modules/bootstrap-fileinput/css', 'public/bootstrap-fileinput/css');
    mix.copy('node_modules/bootstrap-fileinput/themes', 'public/bootstrap-fileinput/themes');
    mix.copy('node_modules/bootstrap-fileinput/img', 'public/bootstrap-fileinput/img');

});

