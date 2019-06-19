<?php
    class Form {
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
            $form = '<form action="process.php" method="POST" enctype="multipart/form-data">';
            $form .= '<input type="text" name="sname" required placeholder="Enter Song">';
            $form .= '<input type="text" name="artist" value="AC/DC">';
            $form .= '<input type="text" name="album" value="Back in Black">';
            $form .= '<input type="file" name="fileToUpload" id="fileToUpload">';
            $form .= '<button type="submit">SUBMIT</button>';
            $form .= '</form>';
            echo $form;     
            
        }

        private function uploadFile() {
            $target_dir = "img/";
            // var_dump($_FILES);
            // die('solong folks');
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            if (!basename($_FILES["fileToUpload"]["name"])) {
                return "";
            }
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            // Check if image file is a actual image or fake image
            if(isset($_POST["submit"])) {
                $check = ($_FILES["fileToUpload"]["tmp_name"]);
                if($check !== false) {
                    // echo "File is an image - " . $check["mime"] . ".";
                    echo "This file is of type : " . mime_content_type($_FILES["fileToUpload"]["tmp_name"]);
                    $uploadOk = 1;
                } else {
                    die("File is not an image.");
                    $uploadOk = 0;
                }
            }
            // Check if file already exists
            if ($file_exists($target_file)) {
                die("Sorry, file already exists.");
                $uploadOk = 0;
            }
            // Check file size
            if ($_FILES["fileToUpload"]["size"] > 500000) {
                die("Sorry, your file is too large.");
                $uploadOk = 0;
            }
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                die("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                die ("Sorry, your file was not uploaded.");
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                } else {
                   die( "Sorry, there was an error uploading your file.");
                }
            }
            if ($uploadOk) { 
                return $target_dir . $_FILES["fileToUpload"]["name"];
            } else {
                return "";
            }
            
        }

        public function process() {
            //we check for keys and set default values if key does not exist
           
            $sname = array_key_exists('sname', $_POST) ? $_POST['sname'] : "New Song";
            $artist = array_key_exists('artist', $_POST) ? $_POST['artist'] : "Unknown";
            $album = array_key_exists('album', $_POST) ? $_POST['album'] : "N/A";
            if (isset($_SESSION) && isset($_SESSION['uid'])) {
                $uid = $_SESSION['uid'];
            } else {
                //FIXME remove die!
                die("User not specified!");
                return;
            }

            $imgsrc = $this->uploadFile();

            $sql = "INSERT INTO tracks (name, artist, album, uid, img)
            VALUES (?, ?, ?, ?, ?)";
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $upstm = $this->db->prepare($sql);
            if(!$upstm->execute([$sname,$artist, $album, $uid, $imgsrc])) {
                die('Not good');
            }
            //We can only reload using header if no html has been sent to page here
            header("Location: index.php");
        }
    }
?>