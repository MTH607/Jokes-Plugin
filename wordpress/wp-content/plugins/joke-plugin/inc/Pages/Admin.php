<?php

/**
 * @package JokePlugin
 */

namespace Inc\Pages;

use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\SettingsApi;
use Inc\Base\BaseController;

/**
 *
 */
class Admin extends BaseController
{
    public $settings;

    public $callbacks;

    public $pages = array();

    public function register()
    {
        $this->settings = new SettingsApi();

        $this->callbacks = new AdminCallbacks();

        $this->setPages();

        $this->setSettings();
        $this->setSections();
        $this->setFields();

        $this->settings->addPages($this->pages)->register();
    }
    public function setPages()
    {

        $this->pages = array(
            array(
                'page_title' => 'Jokes Plugin',
                'menu_title' => 'Settings - Jokes',
                'capability' => 'manage_options',
                'menu_slug' => 'jokes_plugin',
                'callback' => array($this->callbacks, 'settingsApi'),
                'icon_url' => 'dashicons-admin-settings',
                'position' => 110,
            ),
        );
    }

    public function setSettings()
    {
        $args = array(
            array(
                'option_group' => 'joke_options_group',
                'option_name' => 'url',
                'callback' => array($this->callbacks, 'jokeOptionsGroup'),
            ),
            array(
                'option_group' => 'joke_options_group',
                'option_name' => 'url_key',
                'callback' => array($this->callbacks, 'jokeOptionsGroup'),
            ),

            array(
                'option_group' => 'joke_options_group',
                'option_name' => 'nsfw',
                'callback' => array($this->callbacks, 'jokeOptionsGroup'),
            ),
            array(
                'option_group' => 'joke_options_group',
                'option_name' => 'religious',
                'callback' => array($this->callbacks, 'jokeOptionsGroup'),
            ),
            array(
                'option_group' => 'joke_options_group',
                'option_name' => 'political',
                'callback' => array($this->callbacks, 'jokeOptionsGroup'),
            ),
            array(
                'option_group' => 'joke_options_group',
                'option_name' => 'dark',
                'callback' => array($this->callbacks, 'jokeOptionsGroup'),
            ),
        );

        $this->settings->setSettings($args);
    }

    public function setSections()
    {
        $args = array(
            array(
                'id' => 'joke_api_settings',
                'title' => '<br> API Settings',
                'callback' => array($this->callbacks, 'jokeAdminSection'),
                'page' => 'jokes_plugin',
            ),
            array(
                'id' => 'joke_types',
                'title' => '<br> Blacklist Flags',
                'callback' => array($this->callbacks, 'jokeAdminSection'),
                'page' => 'jokes_plugin',
            ),
        );

        $this->settings->setSections($args);
    }

    public function setFields()
    {
        $args = array(
            array(
                'id' => 'url',
                'title' => 'API URL',
                'callback' => array($this->callbacks, 'jokeURL'),
                'page' => 'jokes_plugin',
                'section' => 'joke_api_settings',
                'args' => array(),
            ),
            array(
                'id' => 'url_key',
                'title' => 'API-URL Key',
                'callback' => array($this->callbacks, 'jokeURL_Key'),
                'page' => 'jokes_plugin',
                'section' => 'joke_api_settings',
                'args' => array(),
            ),
            array(
                'id' => 'nsfw',
                'title' => 'NSFW (Not Safe For Work)',
                'callback' => array($this->callbacks, 'jokeNSFW'),
                'page' => 'jokes_plugin',
                'section' => 'joke_types',
                'args' => array(),
            ),
            array(
                'id' => 'religious',
                'title' => 'Religious',
                'callback' => array($this->callbacks, 'jokeReligious'),
                'page' => 'jokes_plugin',
                'section' => 'joke_types',
                'args' => array(),
            ),
            array(
                'id' => 'political',
                'title' => 'Political',
                'callback' => array($this->callbacks, 'jokepolitical'),
                'page' => 'jokes_plugin',
                'section' => 'joke_types',
                'args' => array(),
            ),
            array(
                'id' => 'dark',
                'title' => 'Dark',
                'callback' => array($this->callbacks, 'jokeDark'),
                'page' => 'jokes_plugin',
                'section' => 'joke_types',
                'args' => array(),
            ),
        );

        $this->settings->setFields($args);
    }
}
