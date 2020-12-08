<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require_once 'modules/Alert.php';
require_once 'modules/DBConnection.php';
require_once 'modules/Security.php';

Security::isAuthorized();

$span = '';
$result = '';
$response = '';

if(!empty($_POST['command']))
{
    $cmd = $_POST['command'];
    $db = DBConnection::getConnection($_GET['database']);

    $query = $db->query($cmd);
    if(!$query)
    {
        $span = '<span style="text-align: center; color: red;">';
        $result .= 'Result: ' . $db->errorInfo()[2] . '</span>';
    }
    else
    {
        $span = '<span style="text-align: center; color: green;">';
        $result = 'Result: Success!</span>';
    }
}

function fetchResponse()
{
    global $span;
    global $result;

    return $span . $result;
}

function generateResult()
{
    
}
?>

<html>
<head>
    <title>&lambda; Databases Manager - SQL queries executor</title>
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
        <h1>Executing SQL statement for <?php echo $_GET['database']; ?></h1>
        <a href="index.php" class="w3-button w3-blue">Home</a>

        <h2><?php echo $_POST['command']; ?></h2>
        <h2><?php echo fetchResponse(); ?></h2>

        <h3><?php echo generateResult(); ?></h3>

        <form method="post">
            <textarea name="command" class="w3-input w3-border" style="resize: none;" spellcheck="false" placeholder="Your SQL command"></textarea><br>
            <input type="submit" value="Execute" class="w3-button w3-blue">
        </form>
    </div>
    <div class="w3-col s1 m1 l1">&nbsp;</div>
</div>
</body>
</html>
