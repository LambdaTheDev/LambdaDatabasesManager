<?php
require 'modules/modules_loader.php';
Security::isAuthorized();

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    if(isset($_POST['edit']))
    {
        $fields = $_POST['fields'];
        $jsonFields = json_encode($fields);
        header('Location: editDatabase.php?databases=' . $jsonFields);
        exit();
    }
    else if(isset($_POST['delete']))
    {
        $fields = $_POST['fields'];
        foreach ($fields as $field)
        {
            deleteDb($field);
        }
    }
}

function deleteDb($name)
{
    $pdo = DBConnection::getConnection();
    $query = $pdo->prepare("DROP DATABASE :database");
    $query->bindParam(":database", $name);
    $query->execute();

    if(!$query)
    {
        Alert::setAlert("You don't have permission to drop databases.", 'red');
    }
}

function displayDatabases()
{
    $pdo = DBConnection::getConnection();
    $query = $pdo->query("SHOW DATABASES");

    $result = '<div><form method="post"><table class="w3-table w3-border w3-striped">';
    $result .= '<tr>';
    $result .= '<th><input type="checkbox" class="w3-check" id="checkAll_main" onclick="onCheck(this.checked);"></th>';
    $result .= '<th>Database name</th>';
    $result .= '<th>Collation</th>';
    $result .= '</tr>';

    while ($fetch = $query->fetch(PDO::FETCH_OBJ))
    {
        $name = $fetch->Database;
        $result .= '<tr>';
        $result .= '<td><input type="checkbox" class="w3-check checkAll" name="fields[]" value="'.$name.'"></td>';
        $result .= '<td><a href="showTables.php?database='. $name .'">' . $name . '</a></td>';
        $result .= '<td><span class="w3-text-red">W.I.P.</span></td>';
        $result .= '</tr>';
    }
    $result .= '</table></div>';

    return $result;
}
?>

<html>
<head>
    <meta charset="utf-8">
    <title>&lambda; Databases Manager - Databases</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="includes/checkAll.js"></script>
    <script src="includes/askBeforeSubmit.js"></script>
</head>
<body>
<?php require 'includes/navbar.php'; ?>
<div class="w3-container w3-row-padding">
    <div class="w3-col s1 m1 l2">&nbsp;</div>
    <form method="post" id="dangerous_form">
        <div class="w3-col s10 m10 l8"><br>
            <a href="createDatabase.php" class="w3-button w3-blue">Create database</a>
            <input type="submit" class="w3-button w3-blue" value="Edit database(s)" name="edit">
            <input type="button" class="w3-button w3-red" value="Delete database(s)" name="delete" onclick="ask();">
            <h1>Databases you access to:</h1>
            <?php echo displayDatabases(); ?>
        </div>
    </form>
    <div class="w3-col s1 m1 l2">&nbsp;</div>
</div>
</body>
</html>
