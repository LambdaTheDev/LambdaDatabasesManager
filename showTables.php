<?php
require 'modules/modules_loader.php';
Security::isAuthorized();

function showTablesHTML()
{
    $pdo = DBConnection::getConnection($_GET['database']);

    $query = $pdo->query("SHOW TABLES");

    $result = '<div style="overflow-y: scroll;"><form action="actions/editDatabase.php" method="post"><table class="w3-table w3-bordered w3-striped">'; //todo
    $result .= '<tr>';
    $result .= '<th><input type="checkbox" id="checkAll" class="w3-check"></th>';
    $result .= '<th>Table name</th>';
    $result .= '</tr>';

    while ($table = $query->fetch(PDO::FETCH_ASSOC))
    {
        $tableName = $table['Tables_in_' . $_GET['database']];

        $result .= '<tr>';
        $result .= '<td><input type="checkbox" class="w3-check checkAll_subject" name="field[]" value="' . $tableName . '"></td>';
        $result .= '<td><a href="showRows.php?database=' . $_GET['database'] . '&table=' . $tableName . '">' . $tableName . '</a></td>';
        $result .= '</td>';
    }

    $result .= '</table></form></div>';
    return $result;
}
?>

<html>
<head>
    <title>&lambda; Databases Manager - <?php echo $_GET['database']; ?> database</title>
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
        <h1><?php echo '<a href="index.php">Home</a> > ' .$_GET['database']; ?> tables:</h1>
        <?php echo showTablesHTML(); ?>
    </div>
    <div class="w3-col s1 m1 l1">&nbsp;</div>
</div>
</body>
</html>