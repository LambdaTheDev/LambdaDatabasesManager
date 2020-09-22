<?php
session_start();
require_once 'Security.php';

class PDOConnector
{
    public static function connect($database = null)
    {
        $host = $_SESSION['dbData']['host'];
        $port = $_SESSION['dbData']['port'];
        $user = $_SESSION['dbData']['user'];
        $pass = $_SESSION['dbData']['pass'];

        $pdo = null;

        try
        {
            $conString = "mysql:host=$host;port=$port";
            if($database != null) $conString .= ";dbname=$database";

            $pdo = new PDO($conString, $user, $pass);
        }
        catch (PDOException $ex)
        {
            Alert::setAlert('red', $ex->getMessage());
        }

        return $pdo;
    }
}