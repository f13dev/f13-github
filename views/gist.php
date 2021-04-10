<?php namespace F13\Github\Views;

class Gist
{
    public $label_comments;
    public $label_created;
    public $label_description;
    public $label_download_file;
    public $label_files;
    public $label_gist_created_by;
    public $label_last_edited;
    public $label_na;
    public $label_view_on_github;

    public function __construct( $params = array() )
    {
        foreach ($params as $key => $value) {
            $this->{$key} = $value;
        }

        $this->label_comments = __('Comments', 'f13-github');
        $this->label_created = __('Created', 'f13-github');
        $this->label_description = __('Description', 'f13-github');
        $this->label_download_file = __('Download file', 'f13-github');
        $this->label_files = __('Files', 'f13-github');
        $this->label_gist_created_by = __('Gist created by', 'f13-github');
        $this->label_last_edited = __('Last edited', 'f13-github');
        $this->label_na = __('N/A', 'f13-github');
        $this->label_view_on_github = __('View on GitHub', 'f13-github');
    }

    public function shortcode()
    {
        $v = '<div class="f13-gist-container">';
            $v .= '<div class="f13-gist-header">';
                $v .= '<svg aria-hidden="true" version="1.1" viewBox="0 0 16 16"><path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0 0 16 8c0-4.42-3.58-8-8-8z"></path></svg>';
                $v .= $this->label_gist_created_by.': <a href="https://github.com/' . $this->data['owner']['login'] . '">' . $this->data['owner']['login'] . '</a>';
            $v .= '</div>';
            $v .= '<div class="f13-gist-created">';
                $v .= $this->label_created.': ' . date("F d, Y - h:ia", strtotime($this->data['created_at'])).'<br>';
                $v .= $this->label_last_edited.': ' . date("F d, Y - h:ia", strtotime($this->data['updated_at'])).'<br>';
            $v .= '</div>';
            $v .= '<div class="f13-gist-description">';
                $v .= '<span>'.$this->label_description.':</span> ';
                if ($this->data['description'] != '')
                {
                    $v .= htmlentities($this->data['description']);
                }
                else
                {
                    $v .= $this->label_na;
                }
            $v .= '</div>';
            $v .= '<hr />';
            $v .= '<div class="f13-gist-files-head">';
                $v .= '<span>'.$this->label_files.'</span> (' . count($this->data['files']) . ')';
            $v .= '</div>';
            foreach ($this->data['files'] as &$eachFile)
            {
                $v .= '<svg aria-hidden="true" version="1.1" viewBox="0 0 12 16"><path d="M7.5 5L10 7.5 7.5 10l-.75-.75L8.5 7.5 6.75 5.75 7.5 5zm-3 0L2 7.5 4.5 10l.75-.75L3.5 7.5l1.75-1.75L4.5 5zM0 13V2c0-.55.45-1 1-1h10c.55 0 1 .45 1 1v11c0 .55-.45 1-1 1H1c-.55 0-1-.45-1-1zm1 0h10V2H1v11z"></path></svg>';
                $v .= $eachFile['filename'] . ' (' . round($eachFile['size'] / 1024, 2) . 'kb) <a href="' . $eachFile['raw_url'] . '" download>'.$this->label_download_file.'</a><br />';
                $v .= '<pre class="prettyprint lang-' . strtolower($eachFile['language']) . '" style="border: 1px solid black; margin: 10px; padding: 10px; max-height: 200px; overflow: scroll">';
                    $v .= nl2br(htmlentities($eachFile['content']));
                $v .= '</pre>';
            }
            $v .= '<hr />';
            $v .= $this->label_comments.': <a href="https://gist.github.com/' . $this->data['owner']['login'] . '/' . $this->data['id'] . '#comments">' . $this->data['comments'] . '</a><br>';
            $v .= '<a href="https://gist.github.com/' . $this->data['owner']['login'] . '/' . $this->data['id'] . '">'.$this->label_view_on_github.'</a>';
        $v .= '</div>';

        return $v;
    }
}