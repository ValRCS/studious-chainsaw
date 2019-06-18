<?php
class DB {
    public $conn;

    public function __construct ($server, $user, $pw, $db) {
        try {
            $this->conn = new PDO("mysql:host=$server;dbname=$db", $user, $pw);
            $this->conn->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
            echo "<br>Connected<br>";
        }catch(PDOException $e) {
            die('Error');
        }
    }
}


?>