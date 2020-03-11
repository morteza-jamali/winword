<?php
    namespace WinWord\Includes;

    use WinWord\Admin\WinWord_Admin;

    class WinWord {
        protected $loader;
        protected $plugin_name;
        protected $version;

        public function __construct() {
            if (defined('WinWord_VERSION')) {
                $this->version = WinWord_VERSION;
            } else {
                $this->version = '1.0.0';
            }
            $this->plugin_name = 'winword';

            $this->load_dependencies();
            $this->define_admin_hooks();
        }

        private function load_dependencies() {
            $this->loader = new WinWord_Loader();
        }

        private function define_admin_hooks() {
            $plugin_admin = new WinWord_Admin($this->get_plugin_name(), $this->get_version());
            $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'register_styles');
            $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'register_scripts');
            $this->loader->add_action( 'admin_menu', $plugin_admin, 'add_menu');
        }

        public function run() {
            $this->loader->run();
        }

        public function get_plugin_name() {
            return $this->plugin_name;
        }

        public function get_loader() {
            return $this->loader;
        }

        public function get_version() {
            return $this->version;
        }

    }
?>