<?php
require_once 'modules/modules_loader.php';
Security::isAuthorized();

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $pdo = DBConnection::getConnection();

    $name = $pdo->quote($_POST['name']);
    $collation = $pdo->quote($_POST['collation']);
    $charset = $pdo->quote($_POST['charset']);

    $queryCreate = $pdo->prepare("CREATE DATABASE " . $name);
    $queryCreate->execute();

    if($queryCreate)
    {
        $alter = $pdo->prepare("ALTER DATABASE " . $name . " CHARACTER SET :charset COLLATE :collation");
        $alter->bindParam(':charset', $charset);
        $alter->bindParam(':collation', $collation);
        $alter->execute();

        if(!$alter)
        {
            Alert::setAlert('Failed to set charset & collation, but database has been created. MySQL error: ' . print_r($alter->errorInfo(), true), 'yellow', 'showDatabases.php');
        }
        else
        {
            Alert::setAlert('Database created successfully!', 'green', 'showTables.php?database=' . $name);
        }
    }
    else
    {
        Alert::setAlert('Failed to create database. MySQL error: ' . print_r($queryCreate->errorInfo(), true), 'red', 'showDatabases.php');
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