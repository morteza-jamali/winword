<?php
    namespace AbriCoderPlugin\Includes;

    use AbriCoderPlugin\Admin\AbriCoder_Admin;

    /**
     * @link       https://abricoder.ir
     * @since      1.0.0
     *
     * @package    AbriCoder
     * @subpackage AbriCoder/includes
     */

    /**
     * @since      1.0.0
     * @package    AbriCoder
     * @subpackage AbriCoder/includes
     * @author     Morteza Jamali <mortezajamali4241@gmail.com>
     */
    class AbriCoder {

        /**
         * @since    1.0.0
         * @access   protected
         * @var      AbriCoder_Loader   $loader    Maintains and registers all hooks for the plugin.
         */
        protected $loader;

        /**
         * @since    1.0.0
         * @access   protected
         * @var      string    $plugin_name    The string used to uniquely identify this plugin.
         */
        protected $plugin_name;

        /**
         * @since    1.0.0
         * @access   protected
         * @var      string    $version    The current version of the plugin.
         */
        protected $version;

        /**
         * @since    1.0.0
         */
        public function __construct() {
            if (defined('ABRICODER_VERSION')) {
                $this->version = ABRICODER_VERSION;
            } else {
                $this->version = '1.0.0';
            }
            $this->plugin_name = 'abricoder';

            $this->load_dependencies();
            $this->set_locale();
            $this->define_admin_hooks();
        }

        /**
         * @since    1.0.0
         * @access   private
         */
        private function load_dependencies() {
            $this->loader = new AbriCoder_Loader();
        }

        /**
         * @since    1.0.0
         * @access   private
         */
        private function set_locale() {
            $plugin_i18n = new AbriCoder_i18n();
            $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
        }

        /**
         * @since    1.0.0
         * @access   private
         */
        private function define_admin_hooks() {
            $plugin_admin = new AbriCoder_Admin($this->get_plugin_name(), $this->get_version());
            $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'register_styles');
            $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'register_scripts');
            $this->loader->add_action( 'admin_menu', $plugin_admin, 'add_menu');
        }

        /**
         * @since    1.0.0
         */
        public function run() {
            $this->loader->run();
        }

        /**
         * @since     1.0.0
         * @return    string    The name of the plugin.
         */
        public function get_plugin_name() {
            return $this->plugin_name;
        }

        /**
         * @since     1.0.0
         * @return    AbriCoder_Loader    Orchestrates the hooks of the plugin.
         */
        public function get_loader() {
            return $this->loader;
        }

        /**
         * @since     1.0.0
         * @return    string    The version number of the plugin.
         */
        public function get_version() {
            return $this->version;
        }

    }
?>