<?php
    session_start();
    require_once('../config/config.php');
    require_once('../src/DB.php');

    $db = new DB(SERVER, USER, PW, DB);

    //TODO turn this into a class
    if (isset($_SESSION) && isset($_SESSION['uid'])) {
        //could add authorization level check here
        $uid = $_SESSION['uid'];
    } else {
        //FIXME remove die!
        header("Location: index.php");
    }

    if (isset($_POST) && isset($_POST['delbut'])) {
        echo "POST request button value " . $_POST['delbut'];
    } else {
        echo 'No idea what to delete!';
        die('think again');
        header("Location: index.php");
    }

    $sql = "DELETE FROM tracks WHERE id = ?";
    $db->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $upstm = $db->conn->prepare($sql);
    if(!$upstm->execute([$_POST['delbut']])) {
        die('Not good');
    }
    //We can only reload using header if no html has been sent to page here
    header("Location: index.php");
