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

    use WinWord\Includes\WinWord_Activator;
    use WinWord\Includes\WinWord_Deactivator;
    use WinWord\Includes\WinWord;
    use WinWordCore\App\Config;

    if (!defined( 'WPINC')) {
        die;
    }

    define('WinWord_VERSION', Config::get('version'));

    register_activation_hook( __FILE__, function() {
        WinWord_Activator::activate();
    });
    register_deactivation_hook( __FILE__, function() {
        WinWord_Deactivator::deactivate();
    });

    (new WinWord())->run();
?>
