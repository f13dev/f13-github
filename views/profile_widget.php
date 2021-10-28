<?php namespace F13\Github\Views;

class Profile_widget
{
    public $label_bio;
    public $label_follower;
    public $label_following;
    public $label_github;
    public $label_joined;
    public $label_public_gists;
    public $label_public_repos;
    public $label_starred;

    public function __construct( $params = array() )
    {
        foreach ($params as $key => $value) {
            $this->{$key} = $value;
        }

        $this->label_bio = __('Bio', 'f13-github');
        $this->label_follower = __('Follower', 'f13-github');
        $this->label_following = __('Following', 'f13-github');
        $this->label_github = __('GitHub', 'f13-github');
        $this->label_joined = __('Joined', 'f13-github');
        $this->label_public_gists = __('Public Gists', 'f13-github');
        $this->label_public_repos = __('Public Repos', 'f13-github');
        $this->label_starred = __('Starred', 'f13-github');

    }

    public function widget()
    {
        $v = $this->args['before_widget'];
        $v .= ((!empty(apply_filters('widget_title', $this->instance['title']))) ? $this->args['before_title'].apply_filters('widget_title', $this->instance['title']).$this->args['after_title'] : '');
        //widget content
        if (!empty($this->data['message'])) {
            $v .= '<div class="f13-error">'.$this->data['message'].'</div>';
        } else {
            $v .= '<div class="f13-github-profile-container">';
                $v .= '<a href="https://github.com/'.$this->data['login'].'" class="f13-github-profile-head-link">';
                    $v .= '<div class="f13-github-profile-head">';
                        $v .= '<div class="f13-github-profile-headder">';
                            $v .= '<svg aria-hidden="true" height="18" version="1.1" viewBox="0 0 16 16" width="18"><path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0 0 16 8c0-4.42-3.58-8-8-8z"></path></svg>';
                            $v .= $this->label_github;
                        $v .= '</div>';
                        $v .= '<div class="f13-github-profile-profile-picture">';
                            $v .= '<img loading="lazy" alt="@'.$this->data['login'].' - GitHub avatar" src="' . $this->data['avatar_url'] . '"  />';
                        $v .= '</div>';
                        $v .= '<div class="f13-github-profile-names">';
                            $v .= '<div class="f13-github-profile-name">'.$this->data['name'].'</div>';
                            $v .= '<div class="f13-github-profile-user">@'.$this->data['login'].'</div>';
                        $v .= '</div>';
                    $v .= '</div>';
                $v .= '</a>';

                if (!empty($this->data['bio'])) {
                    $v .= '<div class="f13-github-profile-bio">';
                        $v .= '<span'.$this->label_bio.': </span>'.$this->data['bio'];
                    $v .= '</div>';
                }

                $v .= '<div class="f13-github-profile-info">';
                    $v .= '<span class="f13-github-profile-info-user">';
                        $v .= '<svg aria-hidden="true" height="16" version="1.1" viewBox="0 0 14 16" width="14"><path d="M4.75 4.95C5.3 5.59 6.09 6 7 6c.91 0 1.7-.41 2.25-1.05A1.993 1.993 0 0 0 13 4c0-1.11-.89-2-2-2-.41 0-.77.13-1.08.33A3.01 3.01 0 0 0 7 0C5.58 0 4.39 1 4.08 2.33 3.77 2.13 3.41 2 3 2c-1.11 0-2 .89-2 2a1.993 1.993 0 0 0 3.75.95zm5.2-1.52c.2-.38.59-.64 1.05-.64.66 0 1.2.55 1.2 1.2 0 .65-.55 1.2-1.2 1.2-.65 0-1.17-.53-1.19-1.17.06-.19.11-.39.14-.59zM7 .98c1.11 0 2.02.91 2.02 2.02 0 1.11-.91 2.02-2.02 2.02-1.11 0-2.02-.91-2.02-2.02C4.98 1.89 5.89.98 7 .98zM3 5.2c-.66 0-1.2-.55-1.2-1.2 0-.65.55-1.2 1.2-1.2.45 0 .84.27 1.05.64.03.2.08.41.14.59C4.17 4.67 3.66 5.2 3 5.2zM13 6H1c-.55 0-1 .45-1 1v3c0 .55.45 1 1 1v2c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h1v3c0 .55.45 1 1 1h2c.55 0 1-.45 1-1v-3h1v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-2c.55 0 1-.45 1-1V7c0-.55-.45-1-1-1zM3 13H2v-3H1V7h2v6zm7-2H9V9H8v6H6V9H5v2H4V7h6v4zm3-1h-1v3h-1V7h2v3z"></path></svg>';
                        $v .= $this->data['login'].'<br />';

                        if (!empty($this->data['location'])) {
                            $v .= '<svg aria-hidden="true" height="16" version="1.1" viewBox="0 0 12 16" width="12"><path d="M6 0C2.69 0 0 2.5 0 5.5 0 10.02 6 16 6 16s6-5.98 6-10.5C12 2.5 9.31 0 6 0zm0 14.55C4.14 12.52 1 8.44 1 5.5 1 3.02 3.25 1 6 1c1.34 0 2.61.48 3.56 1.36.92.86 1.44 1.97 1.44 3.14 0 2.94-3.14 7.02-5 9.05zM8 5.5c0 1.11-.89 2-2 2-1.11 0-2-.89-2-2 0-1.11.89-2 2-2 1.11 0 2 .89 2 2z"></path></svg>';
                            $v .= $this->data['location'].'<br />';
                        }

                        if (!empty($this->data['email'])) {
                            $v .= '<svg aria-hidden="true" height="16" version="1.1" viewBox="0 0 14 16" width="14"><path d="M0 4v8c0 .55.45 1 1 1h12c.55 0 1-.45 1-1V4c0-.55-.45-1-1-1H1c-.55 0-1 .45-1 1zm13 0L7 9 1 4h12zM1 5.5l4 3-4 3v-6zM2 12l3.5-3L7 10.5 8.5 9l3.5 3H2zm11-.5l-4-3 4-3v6z"></path></svg>';
                            $v .= '<a href="mailto:'.$this->data['email'].'">'.$this->data['email'].'</a>';
                        }

                    $v .= '</span>';
                    $v .= '<span class="f13-github-profile-info-website">';

                        if (!empty($this->data['blog'])) {
                            $v .= '<svg aria-hidden="true" height="16" version="1.1" viewBox="0 0 16 16" width="16"><path d="M4 9h1v1H4c-1.5 0-3-1.69-3-3.5S2.55 3 4 3h4c1.45 0 3 1.69 3 3.5 0 1.41-.91 2.72-2 3.25V8.59c.58-.45 1-1.27 1-2.09C10 5.22 8.98 4 8 4H4c-.98 0-2 1.22-2 2.5S3 9 4 9zm9-3h-1v1h1c1 0 2 1.22 2 2.5S13.98 12 13 12H9c-.98 0-2-1.22-2-2.5 0-.83.42-1.64 1-2.09V6.25c-1.09.53-2 1.84-2 3.25C6 11.31 7.55 13 9 13h4c1.45 0 3-1.69 3-3.5S14.5 6 13 6z"></path></svg>';
                            $v .= '<a href="'.$this->data['blog'].'">'.$this->data['blog'].'</a><br />';
                        }

                        $v .= '<svg aria-hidden="true" height="16" version="1.1" viewBox="0 0 14 16" width="14"><path d="M8 8h3v2H7c-.55 0-1-.45-1-1V4h2v4zM7 2.3c3.14 0 5.7 2.56 5.7 5.7s-2.56 5.7-5.7 5.7A5.71 5.71 0 0 1 1.3 8c0-3.14 2.56-5.7 5.7-5.7zM7 1C3.14 1 0 4.14 0 8s3.14 7 7 7 7-3.14 7-7-3.14-7-7-7z"></path></svg>';
                        $v .= $this->label_joined.' '.date("F d, Y", strtotime($this->data['created_at']));
                    $v .= '</span>';
                $v .= '</div>';

                $v .= '<div class="f13-github-profile-numbers">';
                    $v .= '<a href="https://github.com/'.$this->data['login'].'/followers">';
                        $v .= '<span>';
                            $v .= '<span>'.$this->data['followers'].'</span><br />';
                            $v .= $this->label_follower;
                        $v .= '</span>';
                    $v .= '</a>';
                    $v .= '<a href="https://github.com/stars/'.$this->data['login'].'">';
                        $v .= '<span>';
                            $v .= '<span>'.$this->starred.'</span><br />';
                            $v .= $this->label_starred;
                        $v .= '</span>';
                    $v .= '</a>';
                    $v .= '<a href="https://github.com/'.$this->data['login'].'/following">';
                        $v .= '<span>';
                            $v .= '<span>'.$this->data['following'].'</span><br />';
                            $v .= $this->label_following;
                        $v .= '</span>';
                    $v .= '</a>';
                $v .= '</div>';
                $v .= '<div class="f13-github-profile-repos">';
                    $v .= '<span class="f13-github-profile-repos-public">';
                        $v .= '<svg aria-hidden="true" class="octicon octicon-repo" height="16" version="1.1" viewBox="0 0 12 16" width="12"><path d="M4 9H3V8h1v1zm0-3H3v1h1V6zm0-2H3v1h1V4zm0-2H3v1h1V2zm8-1v12c0 .55-.45 1-1 1H6v2l-1.5-1.5L3 16v-2H1c-.55 0-1-.45-1-1V1c0-.55.45-1 1-1h10c.55 0 1 .45 1 1zm-1 10H1v2h2v-1h3v1h5v-2zm0-10H2v9h9V1z"></path></svg>';
                        $v .= '<a href="https://github.com/'.$this->data['login'].'/repositories"> '.$this->data['public_repos'].' '.$this->label_public_repos.'</a>';
                    $v .= '</span>';
                    $v .= '<span class="f13-github-profile-repos-gists">';
                        $v .= '<svg aria-hidden="true" height="16" version="1.1" viewBox="0 0 12 16" width="16"><path d="M7.5 5L10 7.5 7.5 10l-.75-.75L8.5 7.5 6.75 5.75 7.5 5zm-3 0L2 7.5 4.5 10l.75-.75L3.5 7.5l1.75-1.75L4.5 5zM0 13V2c0-.55.45-1 1-1h10c.55 0 1 .45 1 1v11c0 .55-.45 1-1 1H1c-.55 0-1-.45-1-1zm1 0h10V2H1v11z"></path></svg>';
                        $v .= '<a href="https://gist.github.com/'.$this->data['login'].'"> '.$this->data['public_gists'].' '.$this->label_public_gists.'</a>';
                    $v .= '</span>';
                $v .= '</div>';
            $v .= '</div>';
        }
        $v .= $this->args['after_widget'];

        return $v;
    }
}