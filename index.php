<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        #test {
            color: red;
        }
    </style>
    <link rel="stylesheet" href="style.css">
</head>
<body>

        <form method="GET" action="search.php">
        <input type="search" id="query" placeholder="search for something" name="q">
        <input type="submit" valie="Send">
    </form>
<br><br>
    <?php
    if(!isset($_SESSION['loggedIn'])){
        echo '<a href="login.php">Login</a>
        <a href="register.php">Register</a>';
    } else {
        echo '<a href="logout.php">Logout</a>';
    }
        ?>

      <?php

      include "components/footer.php";
      ?>

</body>
</html>