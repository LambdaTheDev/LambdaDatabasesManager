<?php
session_start();
require_once 'modules/PDOConnector.php';
require_once 'modules/Security.php';
require_once 'modules/Alert.php';

if(!Security::isLoggedIn())
{
    header('Location: login.php');
    exit();
}

function showDatabasesHTML()
{
    $pdo = PDOConnector::connect();

    $query = $pdo->query("SHOW DATABASES");

    $result = '<div><table class="w3-table w3-bordered w3-striped">';
    $result .= '<tr>';
    $result .= '<th>Database name</th>';
    $result .= '<th>View DB</th>';

    while ($database = $query->fetch(PDO::FETCH_OBJ))
    {
        $result .= '<tr>';
        $result .= '<td>' . $database->Database . '</td>';
        $result .= '<td><a class="w3-container w3-button w3-blue" href="database.php?name=" ' . $database->Database . '>View</a></td>';
        $result .= '</tr>';
    }
    $result .= '</table></div>';
    return $result;
}
?>

<html>
<head>
    <title>&lambda; Databases Manager - Available databases</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
<nav>
    <div class="w3-bar w3-blue">
        <div class="w3-bar-item">&lambda; Databases Manager</div>
        <div class="w3-bar-item"><?php echo $_SESSION['dbData']['user']; ?></div>
        <a class="w3-bar-item w3-button" href="#">All databases</a>
        <a class="w3-bar-item w3-button w3-red" style="text-align: right;" href="login.php?logout=true">Logout</a>
    </div>
</nav>

<div class="w3-container w3-row">
    <div class="w3-col s1 m1 l1">&nbsp;</div>
    <div class="w3-col s10 m10 s10">
        <?php echo Alert::displayAsText(); ?>
        <h1>All available databases:</h1>
        <?php echo showDatabasesHTML(); ?>
    </div>
    <div class="w3-col s1 m1 l1">&nbsp;</div>
</div>
</body>
</html>
