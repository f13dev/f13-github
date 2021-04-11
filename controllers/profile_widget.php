<?php namespace F13\Github\Controllers;


class Profile_widget extends \WP_Widget
{
    public $cache;
    var $textdomain;
    var $fields;

    function __construct( $cache = 1 )
    {
        $this->cache = $cache;
        $this->textdomain = strtolower(get_class($this));

        parent::__construct($this->textdomain, __('GitHub Profile Widget', 'f13-github'), array( 'description' => __('Some description', 'f13-github'), 'classname' => 'f13-github'));
    }

    public function widget($args, $instance)
    {

        $cache_key = 'f13_github_profile_'.serialize($instance);

        $cache = get_transient( $cache_key );
        if ( $cache ) {
            echo $cache;
            return;
        }

        $m = new \F13\Github\Models\Git_api();

        $data = $m->get_user( );
        $starred = $m-> get_starred_count( );

        $v = new \F13\Github\Views\Profile_widget(array(
            'args' => $args,
            'instance' => $instance,
            'data' => $data,
            'starred' => $starred,
        ));

        $return = $v->widget();
        set_transient($cache_key, $return, $this->cache);
        echo $return;
    }

    public function form( $instance )
    {
        $v = '<h4>GitHub profile widget settings</h4>';
        $v .= '<p>The settings for this widget can be found on the <a href="'.admin_url('admin.php').'?page=f13-settings-github">F13Dev GitHub settings page</a>.</p>';
        echo $v;
    }

    public function update($new_instance, $old_instance)
    {
        return $new_instance;
    }

}