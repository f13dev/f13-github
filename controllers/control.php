<?php namespace F13\Github\Controllers;

class Control
{
    private $cache_timeout;

    public function __construct()
    {
        add_shortcode('gist', array($this, 'gist_shortcode'));
        add_shortcode('github', array($this, 'git_shortcode'));
        add_action('widgets_init', array($this, 'github_profile_widget'));

        $this->cache_timeout = get_option('f13_github_cache_timeout','f13-github-group' );
    }

    public function _check_cache( $timeout )
    {
        if ( empty($timeout) ) {
            $timeout = (int) $this->cache_timeout;
        }
        if ( (int) $timeout < 1 ) {
            $timeout = 1;
        }

        $timeout = $timeout * 60;
        
        return $timeout;
    }

    public function gist_shortcode($atts)
    {
        extract(shortcode_atts(array( 'id' => 'false', 'cache' => '' ), $atts));
        $cache = $this->_check_cache( $cache );
        $c = new Gist_shortcode( $id, $cache );
        return $c->shortcode();
    }

    public function git_shortcode($atts)
    {
        extract(shortcode_atts(array( 'user' => 'false', 'repo' => 'false', 'files' => 'hidden', 'cache' => '' ), $atts));
        $cache = $this->_check_cache( $cache );
        $c = new Git_shortcode( $user, $repo, $files, $cache );
        return $c->shortcode();
    }

    public function github_profile_widget()
    {
        $cache = $this->_check_cache( null );
        $c = new Profile_widget( $cache );
        register_widget($c);
    }
}