<?php
require_once 'modules/modules_loader.php';
Security::isAuthorized();

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $name = $_POST['name'];
    $collation = $_POST['collation'];
    $charset = $_POST['charset'];

    $pdo = DBConnection::getConnection();
    $queryCreate = $pdo->prepare("CREATE DATABASE :name");
    $queryCreate->bindParam(':name', $name);
    $queryCreate->execute();

    if($queryCreate)
    {
        $alter = $pdo->prepare("ALTER DATABASE :name CHARACTER SET :charset COLLATE :collation");
        $alter->bindParam(':name', $name);
        $alter->bindParam(':charset', $charset);
        $alter->bindParam(':collation', $collation);
        $alter->execute();

        if(!$alter)
        {
            die('cant alter');
            Alert::setAlert('Failed to alter table (SET CHARSET AND COLLATION). Try again.', 'red');
        }
        else
        {
            die('success');
        }
    }
    else
    {
        die('cant create');
        Alert::setAlert('Failed to create database. Possible reason: no permission.', 'red');
    }
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
        <div class="w3-bar-item">&lambda; Databases Manager - Create database</div>
    </div>
</nav>

<div class="w3-container w3-row-padding">
    <?php Alert::displayAsText(); ?>
    <div class="w3-col s1 m1 l2">&nbsp;</div>
    <div class="w3-col s10 m10 l8">
        <h1>Create new database</h1>
        <form method="post" autocomplete="off">
            <input type="text" class="w3-input" placeholder="Database name" name="name" required>
            <div class="w3-half">
                <?php echo DBConnection::selectCollationHTML(DBConnection::getConnection()); ?>
            </div>
            <div class="w3-half">
                <?php echo DBConnection::selectCharsetHTML(DBConnection::getConnection()); ?>
            </div>
            <br><br>
            <a href="showDatabases.php" class="w3-button w3-blue">All databases</a>
            <input type="submit" value="Create" class="w3-button w3-blue">
        </form>
    </div>
    <div class="w3-col s1 m1 l2">&nbsp;</div>
</div>
</body>
</html>