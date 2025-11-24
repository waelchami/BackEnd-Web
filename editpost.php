<?php
    session_start();
    require 'connection.php';

    if(!isset($_GET['id']) || empty($_GET['id'])){
        header("Location: index.php");
    }

    if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] == false){
        die("Access Denied");
    }

    $postId = htmlspecialchars($_GET['id']);

    $sql = 'SELECT id, text, img, user_id FROM posts WHERE id = :postId';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":postId", $postId);
    $stmt->execute();
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    if($post['user_id'] != $_SESSION['userID']){
        die("Access Denied");   
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
        <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="edit-container">

    <h1>Edit Post</h1>
    <form method="POST" action="actions/editaction.php" enctype="multipart/form-data">
        <textarea cols="50" rows="3" placeholder="What do you want to post?" name="text"><?php echo $post['text'];?></textarea>
        <br><br>
        <img src="<?php echo $post['img'] ?>" width="200px"><br>
        <input type="hidden" name="postId" value="<?php echo $postId;?>">
        <input type="file" name="fileToUpload">
        <br><br>
        <input type="submit" value="Update">
    </form>
    </div>
</body>
</html>