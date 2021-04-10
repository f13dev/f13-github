<?php namespace F13\Github\Controllers;

class Profile_widget extends \WP_Widget
{
    public function __construct()
    {
        $options = array(
            'classname' => 'f13-dev',
            'description' => 'GitHub Profile Widget',
        );
        parent::__construct('f13-dev', 'F13 GitHub Profile', $options);
    }

    public function widget()
    {

    }
}