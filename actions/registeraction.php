<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
require_once "../connection.php";
session_start();
if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']){
    exit();
}

$name = trim($_POST['name']);
$email = trim($_POST['email']);
$password = trim($_POST['pass']);

if(
 !isset($name) ||
 !isset($email) ||
 !isset($password) ||
 empty(trim($name)) ||
 empty(trim($email)) ||
 empty(trim($password))
 ){
    die("Wrong parameters");
}

$name = htmlspecialchars($name);
$email = htmlspecialchars($email);

$password = password_hash($password, PASSWORD_BCRYPT);
$sql = "INSERT INTO users (email, name, password) VALUES (:email, :username, :pass)";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':pass', $password);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':username', $name);
try {
    $stmt->execute();
    $_SESSION['loggedIn'] = true;
    $_SESSION['name'] = $name;
    $_SESSION['userID'] = $pdo->lastInsertId();
    header("Location:../home.php");
    exit();
}catch (Exception $ex) {

    if($ex->getCode() == "23000"){
        header("Location:../register.php?err=2");
        exit();
    } 
    header("Location:../register.php?err=1");
}

