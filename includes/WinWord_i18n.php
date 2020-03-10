<?php

    namespace AbriCoderPlugin\Includes;

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
    class AbriCoder_i18n {

        /**
         * @since    1.0.0
         */
        public function load_plugin_textdomain() {
            load_plugin_textdomain(
                'abricoder',
                false,
                dirname(dirname(plugin_basename( __FILE__ ))) . '/languages/'
            );
        }
    }
?>
