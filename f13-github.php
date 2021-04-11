<?php
/*
Plugin Name: F13 Github
Plugin URI: https://f13.dev/wordpress-plugins/wordpress-plugin-github/
Description: GitHub profile widget, repo shortcode and gist shortcode
Version: 0.0.1
Author: Jim Valentine
Author URI: https://www.f13.dev
Text Domain: f13
*/

namespace F13\Github;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($wpdb)) global $wpdb;
if (!function_exists('get_plugins')) require_once(ABSPATH.'wp-admin/includes/plugin.php');
if (!defined('F13_GITHUB')) define('F13_GITHUB', get_plugin_data(__FILE__, false, false)['Version']);
if (!defined('F13_GITHUB_PATH')) define('F13_GITHUB_PATH', plugin_dir_path( __FILE__ ));
if (!defined('F13_GITHUB_URL')) define('F13_GITHUB_URL', plugin_dir_url(__FILE__));

if (!defined('F13_DB_SETTINGS')) define('F13_DB_SETTINGS', $wpdb->prefix.'f13_settings');

register_activation_hook(__FILE__, array('\F13\Github\Plugin', 'install'));

class Plugin
{
    public function init()
    {
        spl_autoload_register(__NAMESPACE__.'\Plugin::autoload');

        add_action('wp_enqueue_scripts', array($this, 'style_and_scripts'));
        add_action('admin_enqueue_scripts', array($this, 'admin_style_and_scripts'));



        if (is_admin()) {
            $a = new Controllers\Admin();
        }

        $c = new Controllers\Control();
    }

    public static function autoload($class)
    {
        $class = ltrim($class, '\\');
        if (strpos($class, __NAMESPACE__) !== 0) return;
        $class = ltrim(str_replace(__NAMESPACE__, '', $class), '\\');
        $path = F13_GITHUB_PATH.strtolower(str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php');
        require_once $path;
    }

    public function style_and_scripts()
    {
        wp_enqueue_script('google-prettify', 'https://www.doyler.net/code-prettify/loader/run_prettify.js?lang=css&skin=sons-of-obsidian', array(), false, true);

        $styles_ver  = date("ymd-Gis", filemtime( plugin_dir_path( __FILE__ ) . 'css/styles.css' ));
        wp_enqueue_style('f13_github_styles', F13_GITHUB_URL.'css/styles.css', array(), $styles_ver);
    }

    public function admin_style_and_scripts()
    {

    }

    public static function install()
    {
        $i = new Controllers\Install();
        $i->database();
    }
}

$p = new Plugin();
$p->init();