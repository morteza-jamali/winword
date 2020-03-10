<?php
    /**
     * @link              https://abricoder.ir
     * @since             1.0.0
     * @package           WinWord
     *
     * @wordpress-plugin
     * Plugin Name:       WinWord
     * Plugin URI:        https://abricoder.ir
     * Description:       This is WinWord Plugin means Windows in Wordpress !
     * Version:           1.0.0
     * Author:            Morteza Jamali
     * Author URI:        https://abricoder.ir
     * License:           GPL-2.0+
     * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
     * Text Domain:       winword
     * Domain Path:       /languages
     */

    require_once __DIR__ . '/vendor/autoload.php';

    use AbriCoderPlugin\Includes\WinWord_Activator;
    use AbriCoderPlugin\Includes\WinWord_Deactivator;
    use AbriCoderPlugin\Includes\WinWord;
    use AbriCoderCore\Core\Config;

    if (!defined( 'WPINC')) {
        die;
    }

    define('ABRICODER_VERSION', Config::get('version'));

    register_activation_hook( __FILE__, function() {
        WinWord_Activator::activate();
    });
    register_deactivation_hook( __FILE__, function() {
        WinWord_Deactivator::deactivate();
    });

    /**
     * @since    1.0.0
     */
    (new WinWord())->run();
?>
