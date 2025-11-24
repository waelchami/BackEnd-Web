<?php
session_start();
    if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] == false){
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
    <div class="submit-container">

    <h1>Submit Post</h1>
    <form method="POST" action="actions/postaction.php" enctype="multipart/form-data">
        <textarea cols="50" rows="3" class="submit-textarea" placeholder="What do you want to post?" name="text"></textarea>
        <br><br>
        <div class="submit-file">
        <input type="file" name="fileToUpload">
        </div>
        <br><br>
        <input type="submit" value="Post" class="submit-btn">
    </form>
    </div>

</body>
</html>