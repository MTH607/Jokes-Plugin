<?php
/**
 * @package  AlecadddPlugin
 */
namespace Inc\Base;

use Inc\Api\Widgets\jokewidget;
use Inc\Base\BaseController;

/**
 *
 */
class WidgetController extends BaseController
{
    public function register()
    {
        if (!$this->activated('jokes_widget')) {
            return;
        }

        $jokes_widget = new jokewidget();

        $jokes_widget->register();
    }
}
