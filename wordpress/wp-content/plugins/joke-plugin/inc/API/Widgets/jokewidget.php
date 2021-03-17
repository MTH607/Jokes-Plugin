<?php

/**
 * @package JokePlugin
 */

namespace Inc\Api\Widgets;

use WP_Widget;

class jokewidget extends WP_Widget
{
    public $widget_ID;

    public $widget_name;

    public $widget_options = array();

    public $control_options = array();

    public function __construct()
    {
        $this->widget_ID = 'jokes_widget';

        $this->widget_name = 'Jokes Widget';

        $this->widget_options = array(
            'classname' => $this->widget_ID,
            'description' => $this->widget_name,
            'customize_selective_refresh' => true,
        );

        $this->control_options = array(
            'width' => 400,
            'height' => 350,
        );
    }

    public function register()
    {
        parent::__construct($this->widget_ID, $this->widget_name, $this->widget_options, $this->control_options);

        add_action('widgets_init', array($this, 'widgetsInit'));
    }

    public function widgetInit()
    {
        register_widget($this);
    }

    public function form($instance)
    {
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('Custom Text', 'joke_plugin');

        ?>

        <p>

		<label for="<?php echo esc_attr($this->get_field_id('title')); ?>">Title</label>

        <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($title); ?>">

        </p>

<?php
}

}