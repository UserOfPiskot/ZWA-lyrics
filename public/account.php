<?php
require_once "../includes/session.php";
require_once "../config/constants.php";

$title = "Account";

if(!isset($_SESSION["user"])) {
    header("Location: login?backButton=1");
    exit;
}

require_once __DIR__ . "/../includes/models/login.php";


function success(){
    header("Location: account.php?backButton=1&successfullAccountChange=1");
    exit;
}

if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit"])){
    $response = match($_POST["submit"]){
    "Change Username" => isset($_POST["username"], $_POST["password-username"])
    ? changeUsername($conn, $_POST["username"], $_POST["password-username"])
    : -10,
    "Change Email" => isset($_POST["email"], $_POST["password-email"])
    ? changeEmail($conn, $_POST["email"], $_POST["password-email"])
    : -20,
    "Change Password" => isset($_POST["password"], $_POST["password-new"])
    ? changePassword($conn, $_POST["password"], $_POST["password-new"])
    : -30
    /*"Change Profile Picture" => isset($_POST["password-picture"])
    ? changePicture($conn, $_POST["password-picture"])
    : -40,
    "Delete Account" => isset($_POST["password-delete"])
    ? deleteAccount($conn, $_POST["password-delete"])
    : -50,*/
    };

    if(isset($response)){
        // Refresh if action was successful.
        if($response == 1)
            success();

        $response = abs($response);

        if($response < 20){
            $errorType = "username";
        } else if($response < 30){
            $errorType = "email";
        } else if($response < 40){
            $errorType = "password";
        }

        switch($response){
            case 10:
            case 20:
            case 30:
                $errorDetails = "An error occured while changing {$errorType}";
                break;

            case 11:
            case 21:
                $errorDetails = "An account with this {$errorType} already exists";
                break;

            case 13:
            case 23:
            case 31:
                $errorDetails = "Password does not match";
                break;

            case 12:
            case 22:
            case 32:
                $errorDetails = "New {$errorType} is the same as the old one";
                break;

            default:
                $errorDetails = "Unknown error code:";
                break;
        }
        /*echo "showToast('{$errorDetails} ({$response})', 'error')";
        echo "<script>showToast('{$errorDetails} ({$response})', 'error')</script>";*/
        echo "<script>
                window.addEventListener('DOMContentLoaded', () => {
                    showToast('{$errorDetails} ({$response})', 'error');
                });
            </script>";
    }
}

require_once __DIR__ . "/../views/layouts/html_head.phtml";
require_once __DIR__ . "/../views/account.phtml";
require_once __DIR__ . "/../views/layouts/html_foot.phtml";