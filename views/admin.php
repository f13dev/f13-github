<?php namespace F13\Github\Views;

class Admin
{
    public $label_all_wordpress_plugins;
    public $label_api_notice;
    public $label_api_step_1;
    public $label_api_step_2;
    public $label_api_step_3;
    public $label_api_step_4;
    public $label_api_step_5;
    public $label_api_step_6;
    public $label_api_step_7;
    public $label_cache_timeout;
    public $label_github;
    public $label_github_api_token;
    public $label_instructions;
    public $label_obtain_key;
    public $label_plugins_by_f13;
    public $label_save_changes;
    public $label_widget_user;

    public function __construct( $params = array() )
    {
        foreach ($params as $key => $value) {
            $this->{$key} = $value;
        }

        $this->label_all_wordpress_plugins = __('All Wordpress plugins by F13Dev.', 'f13-github');
        $this->label_api_notice = __('This plugin can be used without an API token, although it is recommended to use one as the number of API calls is quite restrictive without one.', 'f13-github');
        $this->label_api_step_1 = __('Log-in to your GitHub account.', 'f13-github');
        $this->label_api_step_2 = __('Visit <a target="_blank" href="https://github.com/settings/tokens">https://github.com/settings/tokens</a>.', 'f13-github');
        $this->label_api_step_3 = __('Click the \'Generate new token\' button at the top of the page/', 'f13-github');
        $this->label_api_step_4 = __('Re-enter your GitHub password for security.', 'f13-github');
        $this->label_api_step_5 = __('Enter a description, such as \'my wordpress site\'.', 'f13-github');
        $this->label_api_step_6 = __('Click the \'Generate token\' button at the bottom of the page, no other setting changes are required.', 'f13-github');
        $this->label_api_step_7 = __('Copy and paste your new API token. Please note, your access token will only be visible once.', 'f13-github');
        $this->label_cache_timeout = __('Cache Timeout (minutes)', 'f13-github');
        $this->label_github = __('GitHub', 'f13-github');
        $this->label_github_api_token = __('GitHub API Token', 'f13-github');
        $this->label_instructions = __('Instructions', 'f13-github');
        $this->label_obtain_key = __('To obtain a GitHub API token', 'f13-github');
        $this->label_plugins_by_f13 = __('Plugins by F13', 'f13-github');
        $this->label_save_changes    = __('Save Changes', 'f13-github');
        $this->label_widget_user    = __('Username for profile widget', 'f13-github');
    }

    public function f13_settings()
    {
        $v = '<div class="wrap">';
            $v .= '<h1>'.$this->label_plugins_by_f13.'</h1>';
            foreach ($this->data->results as $item) {
                $v .= '<div class="plugin-card plugin-card-f13-toc" style="margin-left: 0; width: 100%;">';
                    $v .= '<div class="plugin-card-top">';
                        $v .= '<div class="name column-name">';
                            $v .= '<h3>';
                                $v .= '<a href="plugin-install.php?s='.urlencode('"'.$item->search_term.'"').'&tab=search&type=term" class="thickbox open-plugin-details-modal">';
                                    $v .= $item->title;
                                    $v .= '<img src="'.$item->image.'" class="plugin-icon" alt="">';
                                $v .= '</a>';
                            $v .= '</h3>';
                        $v .= '</div>';
                        $v .= '<div class="desc column-description">';
                            $v .= '<p>';
                                $v .= $item->description;
                            $v .= '</p>';
                            $v .= '.<p class="authors">';
                                $v .= ' <cite>By <a href="'.$item->url.'">Jim Valentine - f13dev</a></cite>';
                            $v .= '</p>';
                        $v .= '</div>';
                    $v .= '</div>';
                $v .= '</div>';
            }
        $v .= '<div>';

        return $v;
    }

    public function github_settings()
    {
        $v = '<div class="wrap">';
            $v .= '<h1>F13 GitHub Settings</h1>';
            $v .= '<p>'.$this->label_api_notice.'</p>';
            $v .= '<div>';
                $v .= $this->label_obtain_key.':';
                $v .= '<ol>';
                    $v .= '<li>'.$this->label_api_step_1.'</li>';
                    $v .= '<li>'.$this->label_api_step_2.'</li>';
                    $v .= '<li>'.$this->label_api_step_3.'</li>';
                    $v .= '<li>'.$this->label_api_step_4.'</li>';
                    $v .= '<li>'.$this->label_api_step_5.'</li>';
                    $v .= '<li>'.$this->label_api_step_6.'</li>';
                    $v .= '<li>'.$this->label_api_step_7.'</li>';
                $v .= '</ol>';
            $v .= '</div>';
        $v .= '</div>';

        $v .= '<form method="post" action="options.php">';
            $v .= '<input type="hidden" name="option_page" value="'.esc_attr('f13-github-group').'" />';
            $v .= '<input type="hidden" name="action" value="update">';
            $v .= '<input type="hidden" id="_wpnonce" name="_wpnonce" value="'.wp_create_nonce('f13-github-group-options').'">';
            do_settings_sections( 'f13-github-group' );
            $v .= '<table class="form-table">';
                $v .= '<tr valign="top">';
                    $v .= '<th scope="row">'.$this->label_github_api_token.':</th>';
                    $v .= '<td>';
                        $v .= '<input type="password" name="f13_github_api_key" value="'.esc_attr( get_option( 'f13_github_api_key' ) ).'" style="width: 50%;"/>';
                    $v .= '</td>';
                $v .= '</tr>';
                $v .= '<tr valign="top">';
                    $v .= '<th scope="row">'.$this->label_cache_timeout.':</th>';
                    $v .= '<td>';
                        $v .= '<input type="number" name="f13_github_cache_timeout" value="'.esc_attr( get_option( 'f13_github_cache_timeout' ) ).'" style="width: 75px;"/>';
                    $v .= '</td>';
                $v .= '</tr>';
                $v .= '<tr valign="top">';
                    $v .= '<th scope="row">'.$this->label_widget_user.':</th>';
                    $v .= '<td>';
                        $v .= '<input type="text" name="f13_github_widget_user" value="'.esc_attr( get_option( 'f13_github_widget_user' ) ).'" style="width: 50%;"/>';
                    $v .= '</td>';
                $v .= '</tr>';
            $v .= '</table>';
            $v .= '<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="'.$this->label_save_changes.'"></p>';
        $v .= '</form>';

        $v .= '<h2>'.$this->label_instructions.'</h2>';
            $v .= __('<b>Repository shortcode</b>: <blockquote>[github user=gituser repo=reponame files=none|names|full|compact cache=time_in_minutes]</blockquote>', 'f13-github').'<br>';
            $v .= __('<b>Gist</b>: <blockquote>[gist id=gist_id cache=time_in_minutes]</blockquote>', 'f13-github');
            $v .= '<ul>';
                $v .= '<li><h3>Files</h3>';
                    $v .= '<ul>';
                        $v .= '<li><b>none</b>: File data within the repository is not included (default).</li>';
                        $v .= '<li><b>names</b>: File names and sizes are included.</li>';
                        $v .= '<li><b>full</b>: Files are returned and displayed in a 200px high box with scroll bars.</li>';
                        $v .= '<li><b>compact</b>: Files are returned and displayed in full.</li>';
                    $v .= '</ul>';
                $v .= '</li>';
            $v .= '</ul>';


        return $v;
    }

    public function widget_settings()
    {

    }
}