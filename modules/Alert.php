<?php
require_once 'Module.php';

class Alert implements Module
{
    public static function setAlert($text, $color, $url = null)
    {
        self::startSession();

        $_SESSION['alert']['color'] = $color;
        $_SESSION['alert']['text'] = $text;
        $_SESSION['alert']['seen'] = false;

        if($url != null)
        {
            header('Location: ' . $url);
        }
    }

    public static function display()
    {
        //todo
    }

    public static function displayAsText($seen = true)
    {
        self::startSession();
        if(empty($_SESSION['alert'])) return null;

        if($_SESSION['alert']['seen'])
        {
            unset($_SESSION['alert']);
            return null;
        }

        $_SESSION['alert']['seen'] = $seen;
        return '<div style="text-align: center; font-size: large;"><span class="w3-text-' . self::getColor() . '">' . self::getText() . '</span></div>';
    }

    public static function getText()
    {
        return $_SESSION['alert']['text'];
    }// Notice: Undefined index: color in /var/www/html/databases-manager/modules/Alert.php on line 47

    public static function getColor()
    {
        return $_SESSION['alert']['color'];
    }

    public static function startSession()
    {
        if(!isset($_SESSION)) session_start();
    }
}