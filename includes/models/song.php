<?php
function getSongs($db, $searchTerm = null): mysqli_result|bool {
    $searchQuery = "
        SELECT songs.*, artists.name AS artistName, artists.artistID AS artistID, artists.artistSlug AS artistSlug
        FROM songs
        JOIN artists ON songs.artistID = artists.artistID
        WHERE 1=1
    ";

    $params = [];

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


function getFromSlug($db, $type, $slug = null): array|bool    {
    $songQuery = "
        SELECT songs.*, artists.name AS artistName, artists.artistSlug AS artistSlug
        FROM songs
        JOIN artists ON songs.artistID = artists.artistID
        WHERE songs.songSlug = ?
    ";

    $artistQuery = "
        SELECT artists.*, COUNT(songs.songID) AS songCount
        FROM artists
        LEFT JOIN songs ON artists.artistID = songs.artistID
        WHERE artists.artistSlug = ?
        GROUP BY artists.artistID
    ";

    if($slug === null || !is_string($slug) || trim($slug) === "") {
        return false;
    }

    $slugQuery = match($type) {
        "song" => $songQuery,
        "artist"=> $artistQuery
    };

    $slug = $_GET["slug"];

    $queryResponse = mysqli_execute_query($db, $slugQuery, [$slug]);

    if (!$queryResponse || mysqli_num_rows($queryResponse) === 0) {
        return false;
    } else {
        return mysqli_fetch_assoc($queryResponse);
    }
}