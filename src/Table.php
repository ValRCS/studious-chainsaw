<?php
    class Table {
        private $db;
        private $limit;

        public function __construct($db, int $limit=10) {
            $this->db = $db;
            $this->limit = $limit;
            $this->render();
        }

        public function render() {
            // HERE we get the date from the table
            if (isset($_SESSION) && isset($_SESSION['user'])) {
                    echo "<h2>Hello " . $_SESSION['user'] . "</h2>";
                    echo "<p>Your user id is " . $_SESSION['uid'] . "</p>";
            }
            $uid = isset($_SESSION['uid']) ? $_SESSION['uid'] : 0;
            echo "<p>Your user id is " . $uid . "</p>";
            $tableheader = false;
            // $query = "SELECT FirstName, LastName, Email FROM MyGuests LIMIT ? ";
           
           //here we control what information to give users
            $query = "SELECT * FROM Tracks WHERE uid = ? LIMIT ?";

            $sth = $this->db->prepare($query);
 
            if(!$sth->execute([$uid, $this->limit])) {
                die('Error');
            }

            //we get all rows here!
            $rows = $sth->fetchAll(PDO::FETCH_ASSOC);

            //render should realy start here
            echo "<hr>";
            echo "<table>";
            foreach ($rows as $row) {
                if($tableheader == false) {
                    echo '<tr>';
                    foreach($row as $key=>$value) {
                        echo "<th>{$key}</th>";
                    }
                    echo '</tr>';
                    $tableheader = true;
                }
                echo "<tr id='row" . $row['id'] . "'>";
                echo "<form action='update.php' method='POST'>";
                foreach($row as $key=>$value) {
                    if ($key == 'id') {
                        echo "<td class='rowid'>{$value}</td>";
                    } else {
                        if (in_array($key, ["name",	"album", "artist", "rating"	])) {
                            echo "<td class='$key'><input type='text' name='$key' value = '$value'></td>";
                        } else {
                            echo "<td class='$key'>{$value}</td>";
                        }
                        
                    }

                }
                echo "<td><button name='updbtn' value='" . $row['id'] . "'>UPDATE</button></td></form>";
                echo "<td><form action='delete.php' method='POST'><button name='delbut' value='" . $row['id'] . "'>DELETE</button></form></td>";
                echo "</tr>";
            }
            echo "</table>";
        }
    }
?>



