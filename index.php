<?php
session_start();
require_once 'modules/PDOConnector.php';

if(!$_SESSION['loggedIn'])
{
    //header('Location: login.php');
    //exit();
}

function showDatabases()
{
    $pdo = PDOConnector::connect();

    $query = $pdo->query("SHOW DATABASES");
    $fetchedDbs = $query->fetchAll(PDO::FETCH_COLUMN);

    $result = '';
    foreach ($fetchedDbs as $oneDatabase)
    {
        $result .= $oneDatabase + "<br>";
    }
    return $result;
}
?>

<html>
<head>
    <title>Databases Manager - Available databases</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
<nav>
    <div class="w3-bar w3-blue">
        <div class="w3-bar-item">Databases Manager</div>
        <a class="w3-bar-item w3-button"><?php echo $_SESSION['dbData']['user']; ?></a>
        <a class="w3-bar-item w3-button" href="#">All databases</a>
    </div>
</nav>

<div class="w3-container w3-row">
    <div class="w3-col s1 m1 l2">&nbsp;</div>
    <div class="w3-col s10 m10 s8">
        <h1>All available databases:</h1>
        <?php echo Alert::displayAsText(); ?>
        <?php echo showDatabases(); ?>
    </div>
    <div class="w3-col s1 m1 l2">&nbsp;</div>
</div>
</body>
</html>
