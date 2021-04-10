<?php namespace F13\Github\Controllers;

class Control
{
    public function __construct()
    {
        add_shortcode('gist', array($this, 'gist_shortcode'));
        add_shortcode('github', array($this, 'git_shortcode'));
        add_action('widgets_init', array($this, 'github_profile_widget'));
    }

    public function gist_shortcode($atts)
    {
        extract(shortcode_atts(array( 'id' => 'false' ), $atts));
        $c = new Gist_shortcode( $id );
        return $c->shortcode();
    }

    public function git_shortcode($atts)
    {
        extract(shortcode_atts(array( 'user' => 'false', 'repo' => 'false', 'files' => 'hidden' ), $atts));
        $c = new Git_shortcode( $user, $repo, $files );
        return $c->shortcode();
    }

    public function github_profile_widget()
    {
        $c = new Profile_widget();
        return $c->widget();
    }
}