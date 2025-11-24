<?php
session_start();

require_once "../connection.php";


if(!(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'])){
    exit();
}

if(!isset($_POST['postId']) || empty(trim($_POST['postId']))){
    die("Missing parameters");
}

$postId = htmlspecialchars($_POST['postId']);
$userId = $_SESSION['userID'];


$sql = "SELECT id FROM posts WHERE id = :postId";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':postId', $postId);
$stmt->execute();
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if(!isset($post['id'])){
    die("Post not found");
}

$sql = "SELECT id FROM likes WHERE post_id = :postId AND user_id = :userId";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':postId', $postId);
$stmt->bindParam(':userId', $userId);
$stmt->execute();
$like = $stmt->fetch(PDO::FETCH_ASSOC);

if(!isset($like['id'])){
    $sql = "INSERT INTO likes (user_id, post_id) VALUES (:userId, :postId)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':userId', $userId);
    $stmt->bindParam(':postId', $postId);
    try {
        $stmt->execute();
        header("Location:../home.php");
        exit();
    }catch (Exception $ex) {
        echo $ex->getMessage();
        exit();
    }
} else {
    $sql = "DELETE FROM likes WHERE id = :likeId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':likeId', $like['id']);
    $stmt->execute();
    header("Location:../home.php");
    exit();
}

