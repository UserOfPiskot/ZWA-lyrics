<?php
require_once __DIR__ . "/../includes/session.php";
require_once __DIR__ . "/../config/constants.php";

$title = "Login";

require_once __DIR__ . "/../includes/models/login.php";

if(isset($_POST["email"])){
    if($_POST["submit"] == "Log in"){
        if(login($conn, $_POST) == 1){
            $_GET = [];
            echo "<script>window.parent.postMessage({ action: 'successfulLogin' }, '" . WEB_URL . "');</script>";
            exit;
        }
    } else{
        $_SESSION["email"] = $_POST["email"];
        $_SESSION["password"] = $_POST["password"];
        header("Location: register?backButton=1");
        exit;
    }
}

require_once __DIR__ . "/../views/layouts/html_head.phtml";
require_once __DIR__ . "/../views/login.phtml";
require_once __DIR__ . "/../views/layouts/html_foot.phtml";

echo "<script>window.parent.postMessage({ action: 'showPasswordButtonCreated' }, '" . WEB_URL . "');</script>";