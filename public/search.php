<?php
require_once __DIR__ . "/../includes/session.php";
require_once __DIR__ . "/../config/constants.php";

require_once __DIR__ . "/../includes/models/song.php";

if(!isset($_GET["searchTerm"]) || !is_string($_GET["searchTerm"]) || trim($_GET["searchTerm"]) === "") {
    header("Location: explore");
    exit;
}

$songs = getSongs($conn, $_GET["searchTerm"]);

if($songs === false) {
    $songs = [];
}

$title = "{$_GET["searchTerm"]} - " . WEB_NAME . " search";

require_once __DIR__ . "/../views/layouts/html_head.phtml";
require_once __DIR__ . "/../views/layouts/song_list.phtml";
require_once __DIR__ . "/../views/layouts/html_foot.phtml";