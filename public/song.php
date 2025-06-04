<?php
require_once __DIR__ . "/../includes/session.php";
require_once __DIR__ . "/../config/constants.php";

require_once __DIR__ . "/../includes/models/song.php";

$song = getFromSlug($conn, "song", $_GET["slug"]);

if ($song === false) {
    header("Location: /explore");
    exit;
}

$title = "{$song["title"]} - " . WEB_NAME;

require_once __DIR__ . "/../views/layouts/html_head.phtml";
require_once __DIR__ . "/../views/song.phtml";
require_once __DIR__ . "/../views/layouts/html_foot.phtml";