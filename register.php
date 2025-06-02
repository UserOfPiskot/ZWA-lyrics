<?php

require "constants.php";

$title = "Register";

require ".pageTop.php";

require "views/register.phtml";

require "functions/fusers.php";

if(isset($_POST["email"])){
    if(register($conn, $_POST) == 1){
        unset($_SESSION["email"]);
        unset($_SESSION["password"]);
        echo "<script>window.parent.postMessage({ action: 'successfulLogin' }, '" . $WEB_URL . "');</script>";
        $_GET = [];
        //echo "<script>window.top.location.href = 'index.php';</script>";
        exit;
    }
}

require "views/html_foot.phtml";

echo "<script>window.parent.postMessage({ action: 'showPasswordButtonCreated' }, '" . $WEB_URL . "');</script>";