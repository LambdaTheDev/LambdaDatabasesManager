<?php
require_once 'Module.php';
require_once 'Security.php';

class DBConnection implements Module
{
    public static function verifyLoginData($host, $port, $user, $pass)
    {
        self::startSession();
        $result = false;

        try
        {
            $pdo = new PDO("mysql:host=$host;port=$port", $user, $pass);
            if($pdo != null) $result = true;
        }
        catch (PDOException $ex)
        {
            $result = false;
        }
        finally
        {
            if($result)
            {
                $_SESSION['connection']['host'] = $host;
                $_SESSION['connection']['port'] = $port;
                $_SESSION['connection']['user'] = $user;
                $_SESSION['connection']['pass'] = $pass;
            }
        }

        return $result;
    }

    public static function getConnection($database = null)
    {
        $host = $_SESSION['connection']['host'];
        $port = $_SESSION['connection']['port'];
        $user = $_SESSION['connection']['user'];
        $pass = $_SESSION['connection']['pass'];

        $pdo = null;
        try
        {
            $dsn = "mysql:host=$host;port=$port";
            if($database != null) $dsn .= ";dbname=$database";

            $pdo = new PDO($dsn, $user, $pass);
        }
        catch (PDOException $ex)
        {
            unset($_SESSION['connection']);
            header('Location: ../index.php');
            exit();
        }

        return $pdo;
    }

    public static function startSession()
    {
        if(!isset($_SESSION)) session_start();
    }

    public static function selectCollationHTML(PDO $pdo)
    {
        $result = '<select name="collation" class="w3-select"><option value="" selected disabled>Collation</option>';
        $result .= '<option value="utf8_bin">utf8_bin</option>';
        $result .= '<option value="latin1_bin">latin1_bin</option>';
        $result .= '<option value="" disabled>Most common</option>';

        $query = $pdo->query("SHOW COLLATION");
        while ($collation = $query->fetch(PDO::FETCH_OBJ))
        {
            $colName = $collation->Collation;
            $result .= '<option value="' . $colName . '">' . $colName . '</option>';
        }

        $result .= '</select>';
        return $result;
    }

    public static function selectCharsetHTML(PDO $pdo)
    {
        $result = '<select name="charset" class="w3-select"><option value="" selected disabled>Charset</option>';
        $result .= '<option value="utf8">utf8</option>';
        $result .= '<option value="latin1">latin1</option>';
        $result .= '<option value="" disabled>Most common</option>';

        $query = $pdo->query("SHOW COLLATION");
        while ($collation = $query->fetch(PDO::FETCH_OBJ))
        {
            $colName = $collation->Charset;
            $result .= '<option value="' . $colName . '">' . $colName . '</option>';
        }

        $result .= '</select>';
        return $result;
    }
}