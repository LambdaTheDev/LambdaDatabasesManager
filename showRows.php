<?php
require 'modules/modules_loader.php';
require 'modules/Row.php';
Security::isAuthorized();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function showRowsHTML()
{
    $pdo = DBConnection::getConnection($_GET['database']);

    $query = $pdo->prepare("DESCRIBE " . $_GET['table']);
    $query->execute();

    $result = '<div style="overflow-y: scroll;"><form action="" method="post"><table class="w3-table w3-bordered w3-striped">'; //todo
    $result .= '<tr>';
    $result .= '<th><input type="checkbox" id="checkAll" class="w3-check"></th>';

    $rowArray = array();
    while($rows = $query->fetch(PDO::FETCH_ASSOC))
    {
        $name = $rows['Field'];
        $type = $rows['Type'];
        $isNull = $rows['Null'];
        $key = $rows['Key'];
        $default = $rows['Default'];
        $extra = $rows['Extra'];

        $obj = new Row($name, $type, $isNull, $key, $default, $extra);
        array_push($rowArray, $obj);
        $result .= '<th>' . $name . '</th>';
    }

    $result .= '</tr>';


    $dbRowsQuery = $pdo->prepare("SELECT * FROM " . $_GET['table']);
    $dbRowsQuery->execute();

    while ($dbRow = $dbRowsQuery->fetch(PDO::FETCH_ASSOC))
    {
        $result .= '<tr>';
        $result .= '<td><input type="checkbox" class="w3-check" id="checkAll_main" onclick="onCheck(this.checked);"></td>';
        foreach ($rowArray as $rowObj)
        {
            $result .= '<td>' . $dbRow[$rowObj->field] . '</td>';
        }
        $result .= '</tr>';
    }

    $result .= '</table></form></div>';
    return $result;
}
?>

<html>
<head>
    <title>&lambda; Databases Manager - <?php echo $_GET['table']; ?> table</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="includes/checkAll.js"></script>
</head>
<body>
<?php require 'includes/navbar.php'; ?>

<div class="w3-container w3-row">
    <div class="w3-col s1 m1 l1">&nbsp;</div>
    <div class="w3-col s10 m10 s10">
        <?php echo Alert::displayAsText(); ?>
        <h1><?php echo '<a href="index.php">Home</a> > <a href="showTables.php?database=' . $_GET['database'] . '">' .$_GET['database'] . '</a>'; ?> > <?php echo $_GET['table'] ?>'s rows:</h1>
        <?php echo showRowsHTML(); ?>
    </div>
    <div class="w3-col s1 m1 l1">&nbsp;</div>
</div>
</body>
</html>