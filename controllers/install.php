<?php namespace F13\Github\Controllers;

class Install
{
    public function database()
    {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        $sql = "CREATE TABLE ".F13_DB_SETTINGS." (
                key varchar(256),
                value varchar(256),
                PRIMARY KEY (key)
        ) ".$charset_collate.";";

        dbDelta($sql);
    }
}