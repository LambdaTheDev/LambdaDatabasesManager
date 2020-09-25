<?php
require_once 'Module.php';

class Security implements Module
{
    public static function start($host, $port, $user, $pass)
    {
        self::startSession();

        $_SESSION['connection']['host'] = $host;
        $_SESSION['connection']['port'] = $port;
        $_SESSION['connection']['user'] = $user;
        $_SESSION['connection']['pass'] = $pass;
        $_SESSION['loggedIn'] = true;
    }

    public static function isAuthorized($forceLogin = true)
    {
        self::startSession();

        if(!isset($_SESSION['connection']) || !isset($_SESSION['loggedIn']))
        {
            if($forceLogin)
            {
                exit();
            }
            return false;
        }

        if(!$_SESSION['loggedIn'])
        {
            if($forceLogin)
            {
                header('Location: index.php#2');
                exit();
            }
            return false;
        }

        return true;
    }

    public static function logout()
    {
        self::startSession();
        unset($_SESSION['connection']);
        unset($_SESSION['loggedIn']);
    }

    public static function startSession()
    {
        if(!isset($_SESSION)) session_start();
    }
}