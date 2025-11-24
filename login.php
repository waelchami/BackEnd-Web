<?php
session_start();
if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']){
    header("Location: index.php");
    exit();
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
    <h1>Website</h1>
    

<h2>Login Form</h2>
    <form method="POST" action="actions/loginaction.php">
        <input type="email" placeholder="Name" id="username" name="email" required>
        <input type="password" placeholder="password" id="pass" name="pass" required>
        <input type="submit" value="login">
    </form>
    <?php
        if(isset($_GET['error'])){
            if($_GET['error'] == 1){
                echo '<h3 style="color:red;">Wrong Information</h3>';
            } 
        }
    ?>
         <?php

include "components/footer.php";
?>
</body>
</html>
