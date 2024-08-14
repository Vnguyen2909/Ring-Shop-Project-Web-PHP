<?php
    require_once("class/Auth.php");
    require_once "class/Database.php";

    $db = new Database();
    $pdo = $db->getConnect();
    $checkCookie = Auth::loginWithCookie($pdo);
    if($checkCookie != null){
        if($checkCookie['role']==1)
            header("Location: index.html");
    }
    else
        header('Location: login.php');
?>