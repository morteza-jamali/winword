let mix = require('laravel-mix');

mix.sass('resources/sass/plugin.sass', 'public/css');
mix.js([
    'node_modules/angular/angular.min.js' ,
    'node_modules/angular-route/angular-route.min.js' ,
    'node_modules/animejs/lib/anime.min.js' ,
    'node_modules/validate.js/validate.min.js' ,
    'node_modules/metro4/build/js/metro.min.js' ,
    'resources/js/routes.js' ,
    'resources/js/app.js' ,
    'resources/js/plugin.js' ,
    'resources/js/winword-email.js'
] , 'public/js/app.js');