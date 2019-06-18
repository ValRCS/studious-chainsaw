<?php
    class Login {
        private $db;
        public function __construct($db) {
            $this->db = $db;
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $this->process();
            } else { //should really only be for GET
                $this->render();
            }
        }
        public function render() {
            if (isset($_SESSION) && isset ($_SESSION['user'])) {
                echo "<h2>Welcome " . $_SESSION['user'] . " </h2>";
            } else {
                echo "You are not logged in!<br>";
            }
            $form = '<form action="login.php" method="POST">';
            $form .= '<input type="text" name="username" placeholder="Enter Your Username" required>';
            $form .= '<input type="password" name="pw" placeholder="Password" required>';
            $form .= '<button type="submit" name="login">Login</button>';
            $form .= '<button type="submit" name="logout">Logout</button>';
            $form .= '</form>';
            echo $form;     
            
        }

        public function process() {
            //we check for keys and set default values if key does not exist
            //TODO check if user already 
            //TODO you might want additional validation here

            
            $username = $_POST['username'];
            $pw = $_POST['pw'];
            
            if (isset($_POST['logout'])) {
                unset($_SESSION['user']);
                unset($_SESSION['uid']);
                // die('You are logged out!');
                header("Location: index.php");
                return;
            }
      
            
            //$hash = password_hash($_POST['pw'], PASSWORD_DEFAULT);
            //TODO REMOVE THIS!!!! 
            // setcookie("PW", $_POST['pw'], time() + (86400 * 30), "/");
            // setcookie("HASH", $hash, time() + (86400 * 30), "/");


 
            $sql = "SELECT id, pwhash FROM users WHERE username = ? LIMIT 1";
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $upstm = $this->db->prepare($sql);
            if(!$upstm->execute([$username])) {
                die('Not good');
            }

            $row = $upstm->fetch(PDO::FETCH_ASSOC);
            // var_dump($row);
            // die("It's all over!");
            //TODO 18.06.2019
            //TODO add fetch line from db and then verify
            //TODO check match and then login
            if (password_verify($pw, $row['pwhash'])) {
                echo 'Password is valid!';
                $_SESSION['user'] = $username;
                $_SESSION['uid'] = $row['id'];

            } else {
                echo 'Invalid password.';
                die("Bad Password!");
            }
           
            //We can only reload using header if no html has been sent to page here
            header("Location: index.php");
        }
    }
?>