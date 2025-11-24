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
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Create an account</h1>
    <form method="POST" action="actions/registeraction.php">
        <input type="text" placeholder="name" name="name" required><br><br>
        <input type="email" placeholder="email" name="email" required><br><br>
        <input type="password" placeholder="password" name="pass" required><br><br>
        <input type="submit" value="Register">
    </form>
    <?php
        if(isset($_GET['err'])){
            if($_GET['err'] == 1){
                echo '<h3 style="color:red;">Wrong Information</h3>';
            } else if($_GET['err'] == 2){
                echo '<h3 style="color:red;">Email already in use</h3>';
            }
        }
    ?>
    <?php

include "components/footer.php";
?>
</body>
</html>