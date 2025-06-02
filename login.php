<?php

require "constants.php";

$title = "Login";

require ".pageTop.php";

require "views/login.phtml";

require "functions/fusers.php";

if(isset($_POST["email"])){
    if($_POST["submit"] == "Log in"){
        if(login($conn, $_POST) == 1){
            $_GET = [];
            echo "<script>window.parent.postMessage({ action: 'successfulLogin' }, '{$WEB_URL}');</script>";
            exit;
        }
    } else{
        $_SESSION["email"] = $_POST["email"];
        $_SESSION["password"] = $_POST["password"];
        header("Location: register?backButton=1");
        exit;
    }
}

require "views/html_foot.phtml";

echo "<script>window.parent.postMessage({ action: 'showPasswordButtonCreated' }, '{$WEB_URL}');</script>";