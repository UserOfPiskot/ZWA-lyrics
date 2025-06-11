<?php

function getSongs($db, $search = null, $genre = null, $style = null): mysqli_result|bool {
    $searchQuery = "
        SELECT songs.*, artists.name AS artistName, artists.artistID AS artistID, artists.artistSlug AS artistSlug, genres.name AS genreName, styles.name AS styleName
        FROM songs, artists, genres, styles
        WHERE 1=1 AND songs.isPublic = 1 AND songs.artistID = artists.artistID AND songs.genreID = genres.genreID AND songs.styleID = styles.styleID;
    "; 

    $params = [];
    
    $searchTerm = $search;

    if ($searchTerm !== null && $searchTerm !== "") {
        $searchTerm = "%" . trim($searchTerm) . "%";
        $searchQuery .= " AND (songs.title LIKE ? OR artists.name LIKE ?)";
        $params[] = $searchTerm;
        $params[] = $searchTerm;
    }
    $songs = mysqli_execute_query($db, $searchQuery, $params);
    if (!$songs || mysqli_num_rows($songs) === 0) {
        return false;
    }
    return $songs;
}

function getGenres($db): mysqli_result|bool {
    $genresQuery = "
        SELECT genres.*
        FROM genres
    ";
    $genres = mysqli_execute_query($db, $genresQuery);
    if (!$genres || mysqli_num_rows($genres) === 0) {
        return false;
    }
    return $genres;
}

function getStyles($db): mysqli_result|bool {
    $stylesQuery = "
        SELECT styles.*
        FROM styles
    ";
    $styles = mysqli_execute_query($db, $stylesQuery);
    if (!$styles || mysqli_num_rows($styles) === 0) {
        return false;
    }
    return $styles;
}

function getArtists($db): mysqli_result|bool {
    $artistsQuery = "
        SELECT artists.*
        FROM artists
    ";
    $artists = mysqli_execute_query($db, $artistsQuery);
    if (!$artists || mysqli_num_rows($artists) === 0) {
        return false;
    }
    return $artists;
}

function getSongSlugsByArtist($db, $artistID): mysqli_result|bool {
    $songsQuery = "
        SELECT songs.*
        FROM songs, artists
        WHERE songs.artistID = ? AND songs.isPublic = 1 AND songs.artistID = artists.artistID
    ";

    $params = [$artistID];

    $songs = mysqli_execute_query($db, $songsQuery, $params);
    if (!$songs || mysqli_num_rows($songs) === 0) {
        return false;
    }
    return $songs;
}

function getFromSlug($db, $type, $slug = null): array|bool    {
    $songQuery = "
        SELECT songs.*, artists.name AS artistName, artists.artistSlug AS artistSlug, users.username AS createdByUsername, users.userID AS createdByUserID
        FROM songs, users, artists
        WHERE songs.songSlug = ? AND users.userID = songs.createdBy AND songs.artistID = artists.artistID;
    ";

    $artistQuery = "
        SELECT artists.*, COUNT(songs.songID) AS songCount
        FROM artists, songs
        WHERE artists.artistSlug = ? AND songs.isPublic = 1 AND songs.artistID = artists.artistID
        GROUP BY artists.artistID;
    ";

    if($slug === null || !is_string($slug) || trim($slug) === "") {
        return false;
    }

    $slugQuery = match($type) {
        "song" => $songQuery,
        "artist"=> $artistQuery
    };


    $queryResponse = mysqli_execute_query($db, $slugQuery, [$slug]);

    if (!$queryResponse || mysqli_num_rows($queryResponse) === 0) {
        return false;
    } else {
        if(($slugQuery === $artistQuery)) {
            return mysqli_fetch_assoc($queryResponse);
        }
        $song = mysqli_fetch_assoc($queryResponse);
        if(!$song["isPublic"] && (!isset($_SESSION["user"]["role"]) || $_SESSION["user"]["role"] < EDIT_CONTENT_FULL)) {
            return false;
        }
        return $song;
    }
}

function getInsertedSongID($db, $slug): bool|mysqli_result {
    $insertedSongQuery = "
        SELECT songs.songID
        FROM songs
        WHERE songs.songSlug = ?;
    ";
    return mysqli_execute_query($db, $insertedSongQuery, [$slug]);
}

function publishSong($db, $songID): bool {
    $publishQuery = "
        UPDATE songs
        SET isPublic = 1
        WHERE songID = ?;
    ";
    return mysqli_execute_query($db, $publishQuery, [$songID]);
}

function hideSong($db, $songID): bool {
    $hideQuery = "
        UPDATE songs
        SET isPublic = 0
        WHERE songID = ?;
    ";
    return mysqli_execute_query($db, $hideQuery, [$songID]);
}

function deleteSong($db, $songID): bool {
    $deleteQuery = "
        DELETE FROM songs
        WHERE songID = ?;
    ";
    return mysqli_execute_query($db, $deleteQuery, [$songID]);
}

function insertSong($db, $title, $lyrics, $colorHex /*$artistID,*/ /*$genreID,*/ /*$styleID,*/): bool {
    $insertQuery = "
        INSERT INTO songs (title, lyrics, colorHex, artistID, genreID, styleID, hasFeat, songSlug, createdBy)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);
    ";

    if(!isset($_SESSION["user"]["userID"])) {
        return false; // User must be logged in to insert a song
    }

    $title = htmlspecialchars(trim($title), ENT_QUOTES, 'UTF-8');
    $artistID = $genreID = $styleID = 1; // Jako vize byla, ze to bude pro vsechny interprety, ale nejak neumim myslet. :(
    $hasFeat = 0;
    $songSlug = slugify($title);

    $params = [$title, $lyrics, $colorHex, $artistID, $genreID, $styleID, $hasFeat, $songSlug, $_SESSION["user"]["userID"]];
    
    return mysqli_execute_query($db, $insertQuery, $params);
}

function editSong($db, $songID, $title, $lyrics, $colorHex /*$artistID,*/ /*$genreID,*/ /*$styleID,*/): bool {
    echo "funkce";
    $editQuery = "
        UPDATE songs
        SET title = ?, lyrics = ?, colorHex = ?
        WHERE songID = ?;
    ";

    if(!isset($_SESSION["user"]["userID"])) {
        return false; // User must be logged in to edit a song
    }

    $title = htmlspecialchars(trim($title), ENT_QUOTES, 'UTF-8');
    
    $params = [$title, $lyrics, $colorHex, $songID];
    
    echo "az na konci jsme";
    return mysqli_execute_query($db, $editQuery, $params);
}