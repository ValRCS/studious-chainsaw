<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
<?php 
require_once('../config/config.php');
require_once('../src/DB.php');
require_once('../src/Login.php');

$db = new DB(SERVER, USER, PW, DB);
$register = new Login($db->conn);

?>
</body>
</html>