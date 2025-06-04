<?php
require_once __DIR__ . "/../includes/session.php";
require_once __DIR__ . "/../config/constants.php";

$title = "Register";

require_once __DIR__ . "/../includes/models/login.php";

if(isset($_POST["email"])){
    if(register($conn, $_POST) == 1){
        unset($_SESSION["email"]);
        unset($_SESSION["password"]);
        echo "<script>window.parent.postMessage({ action: 'successfulLogin' }, '" . WEB_URL . "');</script>";
        $_GET = [];
        //echo "<script>window.top.location.href = 'index.php';</script>";
        exit;
    }
}

require_once __DIR__ . "/../views/layouts/html_head.phtml";
require_once __DIR__ . "/../views/register.phtml";
require_once __DIR__ . "/../views/layouts/html_foot.phtml";

echo "<script>window.parent.postMessage({ action: 'showPasswordButtonCreated' }, '" . WEB_URL . "');</script>";