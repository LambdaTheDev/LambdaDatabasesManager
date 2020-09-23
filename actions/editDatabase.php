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

function showTablesHTML()
{
    $pdo = PDOConnector::connect($_GET['database']);

    $query = $pdo->query("SHOW TABLES");

    $result = '<div><table class="w3-table w3-bordered w3-striped">';
    $result .= '<tr>';
    $result .= '<th>Table name</th>';
    $result .= '<th>View</th>';
    $result .= '</tr>';

    while ($table = $query->fetch(PDO::FETCH_ASSOC))
    {
        $tableName = $table['Tables_in_' . $_GET['database']];

        $result .= '<tr>';
        $result .= '<td>'.$tableName.'</td>';
        $result .= '<td><a class="w3-container w3-button w3-blue" href="showTable.php?database=' . $_GET['database'] . '&table=' . $tableName . '">View</a></td>';
        $result .= '</td>';
    }

    $result .= '</table></div>';
    return $result;
}
?>

<html>
<head>
    <title>&lambda; Databases Manager - <?php echo $_GET['database']; ?> database</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
<nav>
    <div class="w3-bar w3-blue">
        <div class="w3-bar-item">&lambda; Databases Manager</div>
        <div class="w3-bar-item"><?php echo $_SESSION['dbData']['user']; ?></div>
        <a class="w3-bar-item w3-button" href="index.php">All databases</a>

        <a class="w3-bar-item w3-button w3-red" style="text-align: right;" href="login.php?logout=true">Logout</a>
    </div>
</nav>

<div class="w3-container w3-row">
    <div class="w3-col s1 m1 l1">&nbsp;</div>
    <div class="w3-col s10 m10 s10">
        <?php echo Alert::displayAsText(); ?>
        <h1><?php echo $_GET['database']; ?> tables:</h1>
        <?php echo showTablesHTML(); ?>
    </div>
    <div class="w3-col s1 m1 l1">&nbsp;</div>
</div>
</body>
</html>

