<?php
require 'Config.php';

class SessionManager
{
    public static function login($host, $username, $password)
    {
        if(session_status() == PHP_SESSION_DISABLED)
        {
            session_start();
        }

        $expiryDate = date('Y-m-d H:i:s', strtotime("+" . Config::SESSION_TIME . " minutes", strtotime(date('Y-m-d H:i:s'))));

        $_SESSION['auth']['logged_in'] = true;
        $_SESSION['auth']['expiry_date'] = $expiryDate;
        $_SESSION['auth']['host'] = $host;
        $_SESSION['auth']['username'] = $username;
        $_SESSION['auth']['password'] = $password;
    }

    public static function validate()
    {
        if(!empty($_SESSION['auth']['logged_in']))
        {
            http_response_code(401);
            header('Location: /');
            exit();
        }

        $now = date('Y-m-d H:i:s');
        if($now > $_SESSION['auth']['expiry_date'])
        {
            http_response_code(401);
            header('Location: /');
            exit();
        }
    }

    public static function logout()
    {
        unset($_SESSION['auth']);
        if(isset($_SESSION['auth']))
        {
            session_destroy();
        }
    }
}