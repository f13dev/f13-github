<?php namespace F13\Github\Controllers;

class Admin
{
    public function __construct()
    {
        add_action( 'admin_menu', array($this, 'admin_menu') );
        add_action( 'admin_init', array($this, 'register_settings') );
    }

    public function admin_menu()
    {
        global $menu;
        $exists = false;
        foreach($menu as $item) {
            if(strtolower($item[0]) == strtolower('F13 Admin')) {
                $exists = true;
            }
        }
        if(!$exists) {
            add_menu_page( 'F13 Settings', 'F13 Admin', 'manage_options', 'f13-settings', array($this, 'f13_settings'), 'dashicons-embed-generic', 4);
            add_submenu_page( 'f13-settings', 'Plugins', 'Plugins', 'manage_options', 'f13-settings', array($this, 'f13_settings'));
        }
        add_submenu_page( 'f13-settings', 'F13 GitHub Settings', 'GitHub', 'manage_options', 'f13-settings-github', array($this, 'f13_github_settings'));
    }

    public function f13_settings()
    {
        $response = wp_remote_get('https://f13.dev/wp-json/v1/f13-plugins');
        $data     = json_decode(wp_remote_retrieve_body( $response ));

        $v = new \F13\Github\Views\Admin(array(
            'data' => $data,
        ));

        echo $v->f13_settings();
    }

    public function f13_github_settings()
    {
        $v = new \F13\Github\Views\Admin();

        echo $v->github_settings();
    }

    public function register_settings()
    {
        register_setting( 'f13-github-group', 'f13_github_api_key');
        register_setting( 'f13-github-group', 'f13_github_cache_timeout');
        register_setting( 'f13-github-group', 'f13_github_widget_user');
    }
}