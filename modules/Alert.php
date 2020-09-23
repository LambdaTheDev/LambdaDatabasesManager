<?php


class Alert
{
    public static function setAlert($color, $text, $url = null)
    {
        if(session_status() == PHP_SESSION_DISABLED) session_start();

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
        if($_SESSION['alert']['seen'])
        {
            unset($_SESSION['alert']);
            return '';
        }

        $_SESSION['alert']['seen'] = $seen;
        return '<div style="text-align: center; font-size: large;"><span class="w3-text-' . self::getColor() . '">' . self::getText() . '</span></div>';
    }

    public static function getText()
    {
        return $_SESSION['alert']['text'];
    }

    public static function getColor()
    {
        return $_SESSION['alert']['color'];
    }
}