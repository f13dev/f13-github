<?php namespace F13\Github\Controllers;

class Gist_shortcode
{
    private $cache;
    private $id;

    public function __construct( $id = null, $cache = 1 )
    {
        $this->cache = $cache;
        $this->id = $id;
    }

    public function shortcode()
    {
        $cache_key = 'f13_gist_'.$this->id;

        $cache = get_transient( $cache_key );
        if ( $cache ) {
            return $cache;
        }

        $m = new \F13\Github\Models\Git_api();
        $data = $m->get_gist( $this->id );

        if (array_key_exists('message', $data))
        {
            return '<div class="f13-error">The gist could not be found</div>';
        }

        $v = new \F13\Github\Views\Gist(array(
            'data' => $data,
        ));

        $return = $v->shortcode();

        set_transient($cache_key, $return, $this->cache);

        return $return;
    }
}