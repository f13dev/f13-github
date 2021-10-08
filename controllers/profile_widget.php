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

        $this->add_field('title', 'Enter title', '', 'text');

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
        $v = '<p>Set your GitHub API tokens in the <a href="'.admin_url('admin.php').'?page=f13-settings-github">F13 Admin menu</a></p>';
        foreach($this->fields as $field_name => $field_data)
        {
            if($field_data['type'] === 'text')
            {
                $v .= '<p>';
                    $v .= '<label for="'.$this->get_field_id($field_name).'">'._e($field_data['description'], $this->textdomain ).'</label>';
                    $v .= '<input class="widefat" id="'.$this->get_field_id($field_name).'" name="'.$this->get_field_name($field_name).'" type="text" value="'.esc_attr(isset($instance[$field_name]) ? $instance[$field_name] : $field_data['default_value']).'" />';
                $v .= '</p>';
            }
            elseif($field_data['type'] === 'number')
            {
                $v .= '<p>';
                    $v .= '<label for="'.$this->get_field_id($field_name).'">'._e($field_data['description'], $this->textdomain ).'></label>';
                    $v .= '<input class="widefat" id="'.$this->get_field_id($field_name).'" name="'.$this->get_field_name($field_name).'" type="number" value="'.esc_attr(isset($instance[$field_name]) ? $instance[$field_name] : $field_data['default_value']).'" />';
                $v .= '</p>';
            }
            elseif($field_data['type'] === 'password')
            {
                $v .= '<p>';
                    $v .= '<label for="'.$this->get_field_id($field_name).'">'._e($field_data['description'], $this->textdomain ).'</label>';
                    $v .= '<input class="widefat" id="'.$this->get_field_id($field_name).'" name="'.$this->get_field_name($field_name).'" type="password" value="'.esc_attr(isset($instance[$field_name]) ? $instance[$field_name] : $field_data['default_value']).'" />';
                $v .= '</p>';
            }
            elseif($field_data['type'] === 'checkbox')
            {
                $v .= '<p>';
                    $v .= '<label for="'.$this->get_field_id($field_name).'">'._e($field_data['description'], $this->textdomain ).'</label><br />';
                    $v .= '<input id="'.$this->get_field_id($field_name).'" name="'.$this->get_field_name($field_name).'" type="checkbox"';
                    if (esc_attr($instance[$field_name]) == true)
                    {
                        $v .= ' checked';
                    }
                    $v .= '/>';
                $v .= '</p>';
            }
            /* Otherwise show an error */
            else
            {
                $v .= __('Error - Field type not supported', $this->textdomain) . ': ' . $field_data['type'];
            }
        }

        echo $v;
    }

    public function update($new_instance, $old_instance)
    {
        return $new_instance;
    }

    private function add_field($field_name, $field_description = '', $field_default_value = '', $field_type = 'text')
    {
        if(!is_array($this->fields))
            $this->fields = array();

        $this->fields[$field_name] = array('name' => $field_name, 'description' => $field_description, 'default_value' => $field_default_value, 'type' => $field_type);
    }
}