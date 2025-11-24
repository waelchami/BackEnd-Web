<?php
require_once "../connection.php";

session_start();
if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] == false){
    die("Access Denied");
}

$text = trim($_POST['text']);
$text = htmlspecialchars($text, ENT_QUOTES);
$postId = htmlspecialchars($_POST['postId']);

if((!isset($text) || empty($text)) && !isset($_FILES['fileToUpload'])){
    die("Missing Parameters");
}

$sql = 'SELECT  user_id FROM posts WHERE id = :postId';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":postId", $postId);
$stmt->execute();
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if($post['user_id'] != $_SESSION['userID']){
    die("Access Denied");   
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
        $sql = "UPDATE posts SET text= :text, img = :img WHERE id = :postId;";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":text", $text);
        $stmt->bindParam(":img", $target_file);
        $stmt->bindParam(":postId", $postId);
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
    $sql = "UPDATE posts SET text = :text WHERE id = :postId;";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":text", $text);
        $stmt->bindParam(":postId", $postId);

        try {
            $stmt->execute();
            header("Location: ../home.php");
            exit();
        } catch(Exception $ex) {
            echo $ex->getMessage();
            exit();
        }
}

