<?php
require_once __DIR__ . "/../includes/session.php";
require_once __DIR__ . "/../config/constants.php";

if(substr($_SERVER["REQUEST_URI"], 0, 7) === "/search" && empty($_GET["searchTerm"]) && empty($_GET["genre"]) && empty($_GET["style"])) {
    header("Location: explore");
    exit;
}

require_once __DIR__ . "/../includes/models/song.php";

if(isset($_POST["title"])){
    if(insertSong($conn, $_POST["title"], $_POST["lyrics"], $_POST["colorHex"])){
        $insertedSongID = 1;
        if(!file_exists(UPLOAD_PATH . "covers")) {
            if(!mkdir(UPLOAD_PATH . "covers/" . $insertedSongID, /*0755, true*/)) {
                popup("Error creating cover folder!", "error");
                exit;
            }
        }
        if(fileMover("covers/", $insertedSongID, slugify($_POST["title"]))){
            popup("Song has been successfully submitted!", "success");
        } else {
            popup("An error occurred while uploading the cover!", "error");
        }
    } else {
        popup("An error occurred while submitting the song!", "error");
    }
}


$isSearch = False;

if(!empty($_GET["searchTerm"])) {
    $isSearch = True;
}

$songs = fill(getSongs($conn, $_GET["searchTerm"]??null, $_GET["genre"]??null, $_GET["style"]??null));

$artists = fill(getArtists($conn));

$genres = fill(getGenres($conn));

$styles = fill(getStyles($conn));

$overlayClass = "submission";
$overlayHeader = "Submit a new song";
$overlayText = "submit";
$overlayButton = "Submit";

if($isSearch) {
    $title = "{$_GET["searchTerm"]} - " . WEB_NAME . " search";
} else {
    $title = "Explore ". WEB_NAME;
}

require_once __DIR__ . "/../views/layouts/html_head.phtml";
require_once __DIR__ . "/../views/layouts/song_list.phtml";
require_once __DIR__ . "/../views/layouts/html_foot.phtml";