<?php
require_once __DIR__ . "/../includes/session.php";
require_once __DIR__ . "/../config/constants.php";

require_once __DIR__ . "/../includes/models/song.php";

$songs = getSongs($conn, null);

if($songs === false) {
    $songs = [];
}

$title = "Explore ". WEB_NAME;

require_once __DIR__ . "/../views/layouts/html_head.phtml";
require_once __DIR__ . "/../views/layouts/song_list.phtml";
require_once __DIR__ . "/../views/layouts/html_foot.phtml";