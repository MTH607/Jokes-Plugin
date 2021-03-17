<?php

/**
 * @package JokePlugin
 */

namespace Inc\Base;

use \Inc\Base\BaseController;

/**
 *
 */
class Enqueue extends BaseController
{
    public function register()
    {
        add_action('admin_enqueue_scripts', array($this, 'enqueue'));
    }

    public function enqueue()
    {
        wp_enqueue_style('styles', $this->plugin_url . ('/assets/styles.css'));
        wp_enqueue_script('styles', $this->plugin_url . ('/assets/scripts.js'));
    }
}
