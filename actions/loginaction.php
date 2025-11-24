<?php
require_once "../connection.php";

session_start();
if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']){
    exit();
}

if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['email']) && isset($_POST['pass'])){
        $email = $_POST['email'];
        $password = $_POST['pass'];
    } else {
        die("<h1>Missing Parameters, click here to return: <a href='superglobals.php'>Go Back</a>");
    }

    $sql = "SELECT id, name, email, password FROM users WHERE email = :email ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);

    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$user){
        header("Location:../login.php?error=1");
        exit();
    }

    if(password_verify($password, $user['password'])){
        $_SESSION['loggedIn'] = true;
        $_SESSION['name'] = $user['name'];
        $_SESSION['userID'] = $user['id'];
        header("Location:../home.php");
        exit();
    } else {
        header("Location:../login.php?error=1");
        exit();
    }
}
