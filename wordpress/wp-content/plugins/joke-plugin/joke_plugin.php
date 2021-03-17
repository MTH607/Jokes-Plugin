<?php

/**
 * @package JokePlugin
 **/
/*
Plugin Name: Joke Plugin
Plugin URI: https://localhost/wordpress/
Description: This is my first custom joke plugin.
Version: 1.0
Author: Mohammed Tayyab Hussain
Author URI: https://github.com/MTH607
License: GPLv3 or later
Text Domain: jokePlugin
 */

/*
Copyright (©) <2021>  <Mohammed Tayyab Hussain>

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

class joke_plugin
{

    public function __construct()
    {

        defined('ABSPATH') or die('Hey, you can not access this file!');

        //Require once the Composer Autoload
        if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
            require_once dirname(__FILE__) . '/vendor/autoload.php';
        }
        //Initialize all the core classes of the plugin
        if (class_exists('Inc\\Init')) {
            Inc\Init::register_services();
        }
        add_action("init", array($this, 'shortcode'));
    }

    // The code that runs during plugin activation
    public function activate_joke_plugin()
    {
        Inc\Base\Activate::activate();

        register_activation_hook(__FILE__, array($this, 'activate_joke_plugin'));
    }

    // The code that runs during plugin deactivation
    public function deactivate_joke_plugin()
    {
        Inc\Base\Deactivate::deactivate();

        register_deactivation_hook(__FILE__, array($this, 'deactivate_joke_plugin'));
    }

    public function callback_get_joke()
    {
        echo '<div class="wrap">';
        echo '<a href="" onclick="callback_get_joke()"><button>New Joke</button></a>';
        echo '</div>';
        $value_nsfw = esc_attr(get_option('nsfw'));
        $value_religious = esc_attr(get_option('religious'));
        $value_political = esc_attr(get_option('political'));
        $value_dark = esc_attr(get_option('dark'));

        if ($value_nsfw == 'true') {
            $nsfw = ",nsfw";
        } else {
            $nsfw = "";
        }
        if ($value_religious == 'true') {
            $religious = ",religious";
        } else {
            $religious = "";
        }
        if ($value_political == 'true') {
            $political = ",political";
        } else {
            $political = "";
        }
        if ($value_dark) {
            $dark = "Misc,Programming,Pun,Spooky,Christmas";
        } else {
            $dark = "Misc,Programming,Pun,Spooky,Christmas,Dark";
        }

        $value_url = 'https://jokeapi-v2.p.rapidapi.com/joke/' . $dark . '?format=json&blacklistFlags=racist,sexist' . $nsfw . '' . $religious . '' . $political;
        $value_url_key = esc_attr(get_option('url_key'));
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $value_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "x-rapidapi-host: jokeapi-v2.p.rapidapi.com",
                "x-rapidapi-key: $value_url_key",
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $obj = json_decode($response);
        $error = $obj->error;
        $category = $obj->category;
        $type = $obj->type;
        $jokesetup = (isset($obj->setup) ? $obj->setup : false);
        $jokedelivery = (isset($obj->delivery) ? $obj->delivery : false);
        $joke = (isset($obj->joke)) ? $obj->joke : false;
        $nsfw = $obj->flags->nsfw;
        $religious = $obj->flags->religious;
        $political = $obj->flags->political;

        curl_close($curl);
        echo '<p>';
        if ($error == true) {
            echo 'Oh dear, something went wrong. Refresh the page, please.<br>';
            echo $err;
        } else {
            if ($type == 'single') {
                echo $joke . "<br>";
            } elseif ($type == 'twopart') {
                echo $jokesetup . "<br><br>" . $jokedelivery . "<br>";
            }
            echo '<h6>';
            echo $category;
            if ($nsfw == true) {
                echo ", NSFW";
            }
            if ($religious == true) {
                echo ", RELIGIOUS";
            }
            if ($political == true) {
                echo ", POLITICAL";
            }
            echo '</h6>';
        }
        echo '</p>';
    }

    public function shortcode()
    {
        add_shortcode('external_data', array($this, 'callback_get_joke'));
    }
}
if (class_exists("joke_plugin")) {
    $joke_plugin = new joke_plugin();
}
