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

function showTableHTML()
{
    $pdo = PDOConnector::connect($_GET['database']);

    $query = $pdo->query("DESCRIBE " . $_GET['name']);

    $result = '<div><table class="w3-table w3-bordered w3-striped">';
    $result .= '<tr>';
    $result .= '<th>Column name</th>';
    $result .= '<th>Type</th>';
    $result .= '<th>Is null</th>';
    $result .= '<th>Column key</th>';
    $result .= '<th>Default val</th>';
    $result .= '<th>Additional</th>';
    $result .= '</tr>';

    while ($column = $query->fetch(PDO::FETCH_OBJ))
    {
        $default = '<span class="w3-text-red">N/A</span>';
        if($column->Default != null) $default = $column->Default;

        $key = '<span class="w3-text-red">-</span>';
        if($column->Key != null) $key = $column->Key;

        $additional = '<span class="w3-text-red">-</span>';
        if($column->Extra != null) $additional = $column->Extra;

        $result .= '<tr>';
        $result .= '<td>'.$column->Field.'</td>';
        $result .= '<td>'.$column->Type.'</td>';
        $result .= '<td>'.$column->Null.'</td>';
        $result .= '<td>'.$key.'</td>';
        $result .= '<td>'.$default.'</td>';
        $result .= '<td>'.$additional.'</td>';

        $newUrl = 'column.php?database=' . $_GET['database'] . '&table=' . $_GET['name'] . '&column=' . $column->Field;
        $result .= '<td><a class="w3-container w3-button w3-blue" href="' . $newUrl . '">View</a></td>';
        $result .= '</td>';
    }

    $result .= '</table></div>';
    return $result;
}
?>

<html>
<head>
    <title>&lambda; Databases Manager - <?php echo $_GET['name']; ?> table</title>
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
        <h1><?php echo $_GET['name']; ?> tables:</h1>
        <?php echo showTableHTML(); ?>
    </div>
    <div class="w3-col s1 m1 l1">&nbsp;</div>
</div>
</body>
</html>
