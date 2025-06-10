<?php
require_once __DIR__ . "/../includes/session.php";
require_once __DIR__ . "/../config/constants.php";

require_once __DIR__ . "/../includes/models/song.php";

$artist = getFromSlug($conn, "artist", $_GET["slug"]);
$artist["songs"] = getSongSlugsByArtist($conn, $artist["artistID"]);

if ($artist === false) {
    header("Location: /explore");
    exit;
}

$title = "{$artist["name"]} - " . WEB_NAME;

require_once __DIR__ . "/../views/layouts/html_head.phtml";
require_once __DIR__ . "/../views/artist.phtml";
require_once __DIR__ . "/../views/layouts/html_foot.phtml";