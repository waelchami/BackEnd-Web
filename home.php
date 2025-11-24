<?php
require 'connection.php';
session_start();
    if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] == false){
        die("Access Denied");
    }

    $sql = 'SELECT
                p.id as post_id,
                p.text,
                p.img,
                p.user_id,
                p.date_posted,
                u.name,
                COUNT(l.id) as likes,
                MAX(CASE WHEN l.user_id = 29 THEN 1 ELSE 0 END) as isLiked
            FROM posts p
            JOIN users u ON u.id = p.user_id
            LEFT JOIN likes l ON l.post_id = p.id
            GROUP BY l.post_id, p.id; ';

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <div class="header_post">
    <h1>You are logged in as <?php echo $_SESSION['name'];?></h1>
    <a href="submit.php">Submit Post</a>
    <a href="logout.php">Logout</a>
    </div>
    <br><br>
    <h2>Posts</h2>
    <div class="feed-container">

    <?php
        foreach($posts as $post){
            
            echo '<div class="post">';
            if($post['text'] != null){
                echo '<p>' . $post["text"]. '</p>';
            }
            if($post['img'] != null){
                echo "<img src='" . $post['img'] . "' width='200px;'>";
            }
            echo '<div class="post-meta">Posted on ' . $post["date_posted"] . ' by <span class="author_badge"><a href="user.php?id='. $post['user_id'] . '">' . $post["name"] .'</a></span>
            </div>';
            
            echo '<div class="post-footer">
            <span class="likes-count">' . ($post['likes'] == null ? "0" : $post['likes']) . ' people likes this</span>
            <form action="actions/likeaction.php" method="POST">
            <input type="hidden" name="postId" value="'. $post['post_id'] . '">
            <input type="submit" value="'.($post['isLiked'] == 1 ? "Unlike" : "Like") . '">
            </form>
             </div>
    </div>
            <hr>';
        }
        ?>
        </div>
</body>
</html>

