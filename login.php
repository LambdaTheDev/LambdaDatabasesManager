<?php
session_start();
require_once 'modules/Alert.php';
require_once 'modules/Security.php';

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $host = $_POST['host'];
    $port = $_POST['port'];
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    $pdo = null;
    try
    {
        $pdo = new PDO("mysql:host=$host;port=$port", $user, $pass);
        $tempKey = Security::randomString();

        $_SESSION['dbData']['key'] = $tempKey;
        $_SESSION['dbData']['host'] = $host;
        $_SESSION['dbData']['port'] = $port;
        $_SESSION['dbData']['user'] = $user;
        $_SESSION['dbData']['pass'] = Security::AESEncrypt($pass, $tempKey);
        $_SESSION['loggedIn'] = true;
    }
    catch (PDOException $ex)
    {
        Alert::setAlert('red', 'Error when logging in. Probably invalid input.');
    }
}
?>

<html>
<head>
    <title>Databases Manager - Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
<nav>
    <div class="w3-bar w3-blue">
        <div class="w3-bar-item">Databases Manager</div>
        <div class="w3-bar-item w3-button">Login</div>
    </div>
</nav>

<div class="w3-container w3-row">
    <div class="w3-col s1 m1 l2">&nbsp;</div>
    <div class="w3-col s10 m10 l8">
        <?php echo Alert::displayAsText(); ?>
        <h1>Login to system</h1>
        <form method="post">
            <input type="text" style="width: 79%; display: inline-block;" class="w3-input" name="host" placeholder="Host" value="localhost">
            <input type="tel" style="width: 20%; display: inline-block;" class="w3-input" name="port" placeholder="Port" value="3306">
            <input type="text" class="w3-input" name="user" placeholder="Username">
            <input type="password" class="w3-input" name="pass" placeholder="Password"><br>
            <input type="submit" class="w3-button w3-blue" value="Login">
        </form>
    </div>
    <div class="w3-col s1 m1 l2">&nbsp;</div>
</div>

</body>
</html>