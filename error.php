<?php

require "constants.php";

$errorCode = $_SERVER['REDIRECT_STATUS'] ?? 0;

http_response_code($errorCode);

$title = "Error {$errorCode} - {$WEB_NAME}";

require ".pageTop.php";
    
require "./views/error.phtml";
    
require "./views/html_foot.phtml";