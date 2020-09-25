<?php
require 'modules/modules_loader.php';
Security::isAuthorized();

$display = '';

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    foreach (array_keys($_POST['editedName']) as $originalName)
    {
        $newName = $_POST['editedName'][$originalName];
        if($newName == $originalName) continue;

        $pdo = null;
        try
        {
            $pdo = DBConnection::getConnection($originalName);
            //$query = $pdo->prepare("") todo - finish database editing
        }
        catch (PDOException $ex)
        {
            Alert::setAlert('Something went wrong when editing ' . $originalName . ' database. Maybe you do not have permissions?', 'red', 'showDatabases.php');
        }
    }
}
else if(isset($_GET['databases']))
{
    $databases = json_decode($_GET['databases']);
    $display = showDatabasesToEdit($databases);
}
else
{
    header('Location: showDatabases.php');
    exit();
}

function showDatabasesToEdit($databasesList)
{
    $pdo = DBConnection::getConnection();
    $query = $pdo->query("SHOW DATABASES");

    $result = '<div><table class="w3-table w3-border w3-striped">';
    $result .= '<tr>';
    $result .= '<th>Database name</th>';
    $result .= '<th>Collation</th>';
    $result .= '</tr>';

    while ($database = $query->fetch(PDO::FETCH_OBJ))
    {
        $name = $database->Database;

        if(in_array($name, $databasesList))
        {
            $result .= '<tr>';
            $result .= '<td><input type="text" class="w3-input" name="editedName[' . $name . '][]" value="' . $name . '"></td>';
            $result .= '<td>W.I.P.</td>';
            $result .= '</tr>';
        }
    }

    $result .= '</table></div>';
    return $result;
}
?>

<html>
<head>
    <meta charset="utf-8">
    <title>&lambda; Databases Manager - Log in to system</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="includes/checkAll.js"></script>
    <script src="includes/askBeforeSubmit.js"></script>
</head>
<body>
<?php require 'includes/navbar.php'; ?>
<div class="w3-container w3-row-padding">
    <div class="w3-col s1 m1 l2">&nbsp;</div>
    <form method="post" autocomplete="off">
        <div class="w3-col s10 m10 l8"><br>
            <input type="submit" class="w3-button w3-red" value="Edit">
            <a href="showDatabases.php" class="w3-button w3-blue">Cancel</a>
            <h1>Edit databases:</h1>
            <?php echo $display; ?>
        </div>
    </form>
    <div class="w3-col s1 m1 l2">&nbsp;</div>
</div>
</body>
</html>
