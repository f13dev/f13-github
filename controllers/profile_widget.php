<?php namespace F13\Github\Controllers;


class Profile_widget extends \WP_Widget
{
    var $textdomain;
    var $fields;

    function __construct()
    {
        $this->textdomain = strtolower(get_class($this));

        parent::__construct($this->textdomain, __('GitHub Profile Widget', 'f13-github'), array( 'description' => __('Some description', 'f13-github'), 'classname' => 'f13-github'));
    }

    public function widget($args, $instance)
    {
        $m = new \F13\Github\Models\Git_api();

        $data = $m->get_user( );
        $starred = $m-> get_starred_count( );

        $v = new \F13\Github\Views\Profile_widget(array(
            'args' => $args,
            'instance' => $instance,
            'data' => $data,
            'starred' => $starred,
        ));

        echo $v->widget();
    }

    public function form( $instance )
    {
        $v = '<h4>GitHub profile widget settings</h4>';
        $v .= '<p>The settings for this widget can be found on the <a href="'.admin_url('admin.php').'?page=f13-settings-github">F13Dev GitHub settings page</a>.</p>';
        echo $v;
        return;
        /* Generate admin form fields */
        foreach($this->fields as $field_name => $field_data)
        {
            if($field_data['type'] === 'text')
            {
                ?>
                <p>
                    <label for="<?php echo $this->get_field_id($field_name); ?>"><?php _e($field_data['description'], $this->textdomain ); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id($field_name); ?>" name="<?php echo $this->get_field_name($field_name); ?>" type="text" value="<?php echo esc_attr(isset($instance[$field_name]) ? $instance[$field_name] : $field_data['default_value']); ?>" />
                </p>
                <?php

            }
            else
            if($field_data['type'] === 'number')
            {
                ?>
                <p>
                    <label for="<?php echo $this->get_field_id($field_name); ?>"><?php _e($field_data['description'], $this->textdomain ); ?></label>
                    <input class="widefat" id="<?php echo $this->get_field_id($field_name); ?>" name="<?php echo $this->get_field_name($field_name); ?>" type="number" value="<?php echo esc_attr(isset($instance[$field_name]) ? $instance[$field_name] : $field_data['default_value']); ?>" />
                </p>
                <?php
            }
            else
            {
                /* Otherwise show an error */
                echo __('Error - Field type not supported', $this->textdomain) . ': ' . $field_data['type'];
            }
        }
    }

    public function update($new_instance, $old_instance)
    {
        return $new_instance;
    }

}