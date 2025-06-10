<?php
require_once __DIR__ . "/../includes/session.php";
require_once __DIR__ . "/../config/constants.php";

require_once __DIR__ . "/../includes/models/song.php";

$song = getFromSlug($conn, "song", $_GET["slug"]);

if(isset($_POST["title"])){
    if(editSong($conn, $song["songID"], $_POST["title"], $_POST["lyrics"], $_POST["colorHex"])){
        $insertedSongID = 1;
        if(!file_exists(UPLOAD_PATH . "covers")) {
            if(!mkdir(UPLOAD_PATH . "covers/" . $insertedSongID, /*0755, true*/)) {
                popup("Error creating cover folder!", "error");
                exit;
            }
        }
        if(fileMover("covers/", $insertedSongID, slugify($_POST["title"]))){
            popup("Song has been successfully updated!", "success");
            header("Location: /songs/" . $_GET["slug"]);
            exit;
        } else {
            popup("An error occurred while uploading the cover!", "error");
        }
    } else {
        popup("An error occurred while updating the song!", "error");
    }
}

if(isset($_POST["songID"])){
    switch($_POST["action"]){
        case "publish":
            if(publishSong($conn, $_POST["songID"])){
                popup("Song has been successfully published!", "success");
                header("Location: /songs/" . $_GET["slug"]);
                exit;
            } else {
                popup("An error occurred while publishing the song!", "error");
            }
            break;
        case "hide":
            if(hideSong($conn, $_POST["songID"])){
                popup("Song has been successfully hidden!", "success");
                header("Location: /songs/" . $_GET["slug"]);
                exit;
            } else {
                popup("An error occurred while hiding the song!", "error");
            }
            break;
        case "delete":
            if(deleteSong($conn, $_POST["songID"])){
                popup("Song has been successfully deleted!", "success");
                header("Location: /explore");
                exit;
            } else {
                popup("An error occurred while deleting the song!", "error");
            }
            break;
    }
}

if ($song === false) {
    header("Location: /explore");
    exit;
}

$overlayClass = "editing";
$overlayHeader = "Edit this song";
$overlayText = "edit";
$overlayButton = "Save changes";

$title = "{$song["title"]} - " . WEB_NAME;

require_once __DIR__ . "/../views/layouts/html_head.phtml";
require_once __DIR__ . "/../views/song.phtml";
require_once __DIR__ . "/../views/layouts/html_foot.phtml";