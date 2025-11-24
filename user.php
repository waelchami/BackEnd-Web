<?php
require 'connection.php';
session_start();

if(!isset($_GET['id']) || empty($_GET['id'])){
    header("Location: index.php");
}

$profileId = htmlspecialchars($_GET['id']);

$sql = 'SELECT id, name, email, created_at FROM users WHERE id = :userId';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":userId", $profileId);
$stmt->execute();
$profile = $stmt->fetch(PDO::FETCH_ASSOC);

if(!isset($profile['id'])){
    die("User not found");
}

$isOwner = $profileId;
$_SESSION['userID'] == $profileId;

$sql =      'SELECT
                p.id as post_id,
                p.text,
                p.img,
                p.user_id,
                p.date_posted,
                u.name
            FROM posts p
            JOIN users u ON u.id = p.user_id
            WHERE p.user_id = :userId';

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":userId", $profileId);
    $stmt->execute();
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $profile['name']; ?>'s Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1><?php echo $profile['name']; ?>'s Profile</h1>
    <h2>Posts</h2>
    <div class="profile-container">
    <?php
        foreach($posts as $post){
            echo " <div class='post'>";
            if($post['text'] != null){
                echo '<p>' . $post["text"]. '</p>';
            }
           
            if($post['img'] != null){
                echo "<img src='" . $post['img'] . "' width='200px;'>";
            }
            echo '<br><span>Posted on ' . $post["date_posted"] . ' by ' . $post["name"] .'</span>';
            if($isOwner){
                echo '<a href="editpost.php?id='. $post['post_id'] . '" style="margin-left:10px;">Edit</a>';
            }
            echo '<hr>
            </div>';
        }
    ?>
    </div>
</body>
</html>