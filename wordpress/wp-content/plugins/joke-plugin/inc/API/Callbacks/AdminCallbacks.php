<?php
/**
 * @package JokePlugin
 */

namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class AdminCallbacks extends BaseController
{
    public $nsfw;
    public $religious;
    public $political;

    public function settingsApi()
    {
        return require_once "$this->plugin_path/templates/admin.php";
    }

    public function jokeOptionsGroup($input)
    {
        return $input;
    }

    public function jokeAdminSection()
    {
        echo '';
    }

    public function jokeURL()
    {
        $value_nsfw = esc_attr(get_option('nsfw'));
        $value_religious = esc_attr(get_option('religious'));
        $value_political = esc_attr(get_option('political'));
        $value_dark = esc_attr(get_option('dark'));

        if ($value_nsfw == 'true') {
            $this->nsfw = ",nsfw";
        } else {
            $this->nsfw = "";
        }if ($value_religious == 'true') {
            $this->religious = ",religious";
        } else {
            $this->religious = "";
        }if ($value_political == 'true') {
            $this->political = ",political";
        } else {
            $this->political = "";
        }if ($value_dark) {
            $this->dark = "Misc,Programming,Pun,Spooky,Christmas";
        } else {
            $this->dark = "Misc,Programming,Pun,Spooky,Christmas,Dark";
        }

        $value_url = 'https://jokeapi-v2.p.rapidapi.com/joke/' . $this->dark . '?format=json&blacklistFlags=racist,sexist' . $this->nsfw . '' . $this->religious . '' . $this->political;

        echo '<input type="text" value="' . $value_url . '" size="50" name="url" readonly>';
    }
    public function jokeURL_Key()
    {
        $value_url_key = esc_attr(get_option('url_key'));

        echo '<input type="text" value="' . $value_url_key . '" size="50" name="url_key" disabled readonly>';

    }
    public function jokeNSFW()
    {
        $value_nsfw = esc_attr(get_option('nsfw'));

        if ($value_nsfw == 'true') {
            echo '<input type="checkbox" value="true" name="nsfw" checked>';
        } else {
            echo '<input type="checkbox" value="true" name="nsfw">';
        }
    }

    public function jokeReligious()
    {
        $value_religious = esc_attr(get_option('religious'));

        if ($value_religious == 'true') {
            echo '<input type="checkbox" value="true" name="religious" checked>';
        } else {
            echo '<input type="checkbox" value="true" name="religious">';
        }
    }

    public function jokePolitical()
    {
        $value_political = esc_attr(get_option('political'));

        if ($value_political == 'true') {
            echo '<input type="checkbox" value="true" name="political" checked>';
        } else {
            echo '<input type="checkbox" value="true" name="political">';
        }
    }

    public function jokeDark()
    {
        $value_dark = esc_attr(get_option('dark'));

        if ($value_dark == 'true') {
            echo '<input type="checkbox" value="true" name="dark" checked>';
        } else {
            echo '<input type="checkbox" value="true" name="dark">';
        }
    }
}
