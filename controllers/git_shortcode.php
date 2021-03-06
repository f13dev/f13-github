<?php namespace F13\Github\Controllers;

class Git_shortcode
{
    private $cache;
    private $files;
    private $repo;
    private $user;

    public function __construct( $user = '', $repo = '', $files = 'hidden', $cache = 1 )
    {
        $this->cache = $cache;
        $this->files = $files;
        $this->repo = $repo;
        $this->user = $user;
    }

    public function shortcode()
    {
        $cache_key = 'f13_github_repo'.sha1(serialize( $this->user.$this->repo.$this->files ));

        $cache = get_transient( $cache_key );
        if ( $cache ) {
            echo '<script>console.log("Building git shortcode from transient: '.$cache_key.'");</script>';
            return $cache;
        }

        $m = new \F13\Github\Models\Git_api();
        $data = $m->get_repository( $this->user, $this->repo );

        if (array_key_exists('message', $data))
        {
            return '<div class="f13-error">'.$data['message'].'</div>';
        }

        $files = false;

        if ($this->files != 'hidden') {
            $files = $m->get_repository_files( $this->user, $this->repo );
        }

        $v = new \F13\Github\Views\Repo(array(
            'files' => $files,
            'data' => $data,
            'show_files' =>$this->files,
            'repo' => $this->repo,
            'user' => $this->user,
        ));

        $return = $v->shortcode();

        set_transient($cache_key, $return, $this->cache);
        echo '<script>console.log("Building git shortcode from API, setting transient: '.$cache_key.'");</script>';

        return $return;
    }
}