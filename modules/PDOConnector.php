<?php
require 'Config.php';

class PDOConnector
{
    public static function getAdminConnection($databaseName)
    {
        $pdo = null;
        try
        {
            $pdo = new PDO('mysql:host=' . Config::HOST . ';dbname=' . $databaseName, Config::ADMIN_USERNAME, Config::ADMIN_PASSWORD);
        }
        catch (PDOException $ex)
        {
            die('LambdaDatabasesManager wrongly configured! Please fix your Config.php file in modules folder! Exception message: ' . $ex->getMessage());
        }
        return $pdo;
    }

    public static function connect($host, $databaseName, $username, $password)
    {
        $pdo = null;

        try
        {
            $pdo = new PDO('mysql:host=' . $host . ';dbname=' . $databaseName, $username, $password);
        }
        catch (PDOException $ex)
        {
            return array(
                'code' => $ex->getCode(),
                'message' => $ex->getMessage()
            );
        }

        return $pdo;
    }
}