<?php
if (!isset($_SERVER['HTTP_SEC_FETCH_DEST']) || $_SERVER['HTTP_SEC_FETCH_DEST'] !== 'iframe') {
    http_response_code(403);
    //header("Location: error403.php");
    exit;
}