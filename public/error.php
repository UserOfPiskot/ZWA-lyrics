<?php
require_once __DIR__ . "/../includes/session.php";
require_once __DIR__ . "/../config/constants.php";

$errorCode = $_SERVER['REDIRECT_STATUS'] ?? 0;

http_response_code($errorCode);

$title = "Error {$errorCode} - " . WEB_NAME;

require_once __DIR__ . "/../views/layouts/html_head.phtml";
require_once __DIR__ . "/../views/error.phtml";
require_once __DIR__ . "/../views/layouts/html_foot.phtml";