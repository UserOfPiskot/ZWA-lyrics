<?php

require "constants.php";

if(isset($_GET["searchTerm"])){
    if($_GET["searchTerm"] == ""){
        header("Location: explore");
        exit;
    }
} else{
    header("Location: explore");
    exit;
}

$title = "{$_GET["searchTerm"]} {$WEB_NAME} search";

require ".pageTop.php";

require "./views/search.phtml";

require "./views/html_foot.phtml";