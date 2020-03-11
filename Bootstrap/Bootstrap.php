<?php
    namespace WinWord\Bootstrap;

    use Noodlehaus\AbstractConfig;

    class Bootstrap extends AbstractConfig {
        protected function getDefaults() {
            return [
                'url' => [
                    'img' => plugin_dir_url(__DIR__) . 'public/img/'
                ] ,
                'path' => [
                    'views' => dirname(__DIR__) . '/resources/views/'
                ] ,
                'scripts' => [
                    'angular' => plugin_dir_url(__DIR__) . 'node_modules/angular/angular.min.js' ,
                    'validate' => plugin_dir_url(__DIR__) . 'node_modules/validate.js/validate.min.js' ,
                    'metro' => plugin_dir_url(__DIR__) . 'node_modules/metro4/build/js/metro.min.js' ,
                    'plugin' => plugin_dir_url(__DIR__) . 'public/js/plugin.js'
                ] ,
                'styles' => [
                    'fontawesome' => plugin_dir_url(__DIR__) . 'node_modules/@fortawesome/fontawesome-free/css/all.min.css' ,
                    'metro' => plugin_dir_url(__DIR__) . 'node_modules/metro4/build/css/metro-all.min.css' ,
                    'plugin' => plugin_dir_url(__DIR__) . 'public/css/plugin.css'
                ]
            ];
        }
    }
?>
