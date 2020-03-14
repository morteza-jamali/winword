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
                    'app' => plugin_dir_url(__DIR__) . 'public/js/app.js'
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
