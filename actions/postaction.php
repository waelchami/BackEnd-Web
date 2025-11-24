<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
require_once "../connection.php";

session_start();
if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] == false){
    die("Access Denied");
}

$text = trim($_POST['text']);
$text = htmlspecialchars($text, ENT_QUOTES);

if((!isset($text) || empty($text)) && !isset($_FILES['fileToUpload'])){
    die("Missing Parameters");
}

if (!empty($_FILES['fileToUpload']['name'])){
    $ext = strtolower(pathinfo($_FILES['fileToUpload']['name'], PATHINFO_EXTENSION));

    $target_file = 'uploads/' . "IMG_" . $_SESSION['userID'] . "_" . bin2hex(random_bytes(5)) . "." . $ext;



    if(file_exists($target_file)){
    die("File already exists");
    }

    if($ext != "png" && $ext != 'jpg' && $ext != "jpeg" && $ext != "gif"){
    die("Unaccepted file format");
    }

    if(getimagesize($_FILES['fileToUpload']['tmp_name']) == false){
    die("File is not a valid image");
    }

    if($_FILES['fileToUpload']['size'] > 1000000){
    die("File is too large");
    }

    if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], "../$target_file")){
        $sql = "INSERT INTO posts (text, img, user_id) VALUES(:text, :img, :user_id);";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":text", $text);
        $stmt->bindParam(":img", $target_file);
        $stmt->bindParam(":user_id", $_SESSION['userID']);
        try {
            $stmt->execute();
            header("Location: ../home.php");
            exit();
        } catch(Exception $ex) {
            echo $ex->getMessage();
            exit();
        }
    } else {
    echo "Failed to upload";
    }
} else {
    $sql = "INSERT INTO posts (text, user_id) VALUES(:text, :user_id);";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":text", $text);
        $stmt->bindParam(":user_id", $_SESSION['userID']);
        try {
            $stmt->execute();
            header("Location: ../home.php");
            exit();
        } catch(Exception $ex) {
            echo $ex->getMessage();
            exit();
        }
}

