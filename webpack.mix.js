let mix = require('laravel-mix');

mix.sass('resources/sass/plugin.sass', 'public/css');
mix.js([
    'node_modules/angular/angular.min.js' ,
    'node_modules/validate.js/validate.min.js' ,
    'node_modules/metro4/build/js/metro.min.js' ,
    'resources/js/plugin.js'
] , 'public/js/app.js');