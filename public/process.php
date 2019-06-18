<?php
    session_start();
    require_once('../config/config.php');
    require_once('../src/DB.php');
    require_once('../src/Form.php');
    $db = new DB(SERVER, USER, PW, DB);
    $form = new Form($db->conn);



?>