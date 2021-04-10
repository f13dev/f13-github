<?php namespace F13\Github\Models;

class Git_api
{
    private $key;

    public function __construct()
    {
        $this->key = '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';
    }

    public function _api( $url )
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPGET, true);

        if (preg_replace('/\s+/', '', $this->key) != '' || $this->key != null) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: token '.$this->key,
            ));
        } else {
            curl_setopt($curl, CURLOPT_HTTPHEADERS, array(
                'Content-Type: application/json',
                'Accept: application/json',
            ));
        }

        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.114 Safari/537.36');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($curl);

        curl_close($curl);

        return json_decode($result, true);
    }

    public function get_gist( $id )
    {
        return $this->_api( 'https://api.github.com/gists/'.$id );
    }

    public function get_repository( $user, $repo)
    {
        return $this->_api( 'https://api.github.com/repos/'.$user.'/'.$repo );
    }

    public function get_recursive_repository_files( $start )
    {
        $files = array();
        $data = $this->_api( $start );
        foreach ($data as $each) {
            if ($each['type'] == 'dir') {
                //$files[$each['path']] = $this->get_recursive_repository_files( $each['url'] );
                $sub = $this->get_recursive_repository_files( $each['url'] );
                $files = array_merge($files, $sub);
            } else if ($each['type'] == 'file') {
                //$files[$each['path']] = $each['download_url'];
                $files[$each['path']] = $each;
            }
        }
        return $files;
    }

    public function get_repository_files( $user, $repo )
    {
        $data = $this->get_recursive_repository_files( 'https://api.github.com/repos/'.$user.'/'.$repo.'/contents/' );
        return $data;
        return $this->_api( 'https://api.github.com/repos/'.$user.'/'.$repo.'/contents/' );
    }
}