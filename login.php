<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'modules/modules_loader.php';

if(isset($_GET['logout']) && $_GET['logout'] == true)
{
    Security::logout();
    Alert::setAlert('Logged out successfully!', 'green', 'login.php');
}

//if(Security::isAuthorized(false))
//{
//    header('Location: index.php');
//    exit();
//}

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $host = $_POST['host'];
    $port = $_POST['port'];
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    $verify = DBConnection::verifyLoginData($host, $port, $user, $pass);
    if(!$verify)
    {
        Alert::setAlert('Invalid login data! Please try again.', 'red');
    }

    Security::start($host, $port, $user, $pass);
    header('Location: index.php');
    exit();
}
?>

<html>
<head>
    <meta charset="utf-8">
    <title>&lambda; Databases Manager - Log in to system</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
<nav>
    <div class="w3-blue w3-bar">
        <div class="w3-bar-item">&lambda; Databases Manager - Login to system</div>
    </div>
</nav>

<div class="w3-container w3-row-padding">
    <?php Alert::displayAsText(); ?>
    <div class="w3-col s1 m1 l2">&nbsp;</div>
    <div class="w3-col s10 m10 l8">
        <h1>&lambda; Databases Manager - Login</h1>
        <form method="post">
            <div class="w3-row">
                <div class="w3-col s8 m8 l9">
                    <input class="w3-input" type="text" name="host" placeholder="Host" value="localhost" required>
                </div>
                <div class="w3-col s4 m4 l3">
                    <input class="w3-input" type="tel" name="port" placeholder="Port" value="3066" required>
                </div>
            </div>
            <input class="w3-input" type="text" name="user" placeholder="Username" required>
            <input class="w3-input" type="password" name="pass" placeholder="Password">

            <br><input type="submit" value="Login" class="w3-button w3-blue">
        </form>
    </div>
    <div class="w3-col s1 m1 l2">&nbsp;</div>
</div>
</body>
</html>