<?php
function getList($db, $type, $filterBy = null): mysqli_result|bool {
    $reportQuery = "
        SELECT *, users.username AS reportedUserName
        FROM reports, users
        WHERE reports.reportedID = users.userID
        ORDER BY reports.creationTimestamp DESC
    ";
    $sumbissionQuery = "
        SELECT songs.*, users.username AS createdByUsername, artists.name AS artistName, artists.artistSlug AS artistSlug, genres.name AS genreName
        FROM songs, users, artists, genres
        WHERE isPublic = 0 AND songs.createdBy = users.userID AND songs.artistID = artists.artistID AND songs.genreID = genres.genreID
        ORDER BY creationTimestamp DESC
    ";

    $flaggedQuery = "
        SELECT *
        FROM user
        ORDER BY creationTimestamp DESC
    ";

    $auditQuery = "
        SELECT *
        FROM audits
        ORDER BY creationTimestamp DESC
    ";

    $usersQuery = "
        SELECT *
        FROM users
        WHERE users.userID <> 0
        ORDER BY creationTimestamp DESC
    ";

    if(($type !== "submissions") && ($type !== "users")) {
        return false;
    }

    $listQuery = match($type) {
        "reports" => $reportQuery,
        "submissions" => $sumbissionQuery,
        "flagged" => $flaggedQuery,
        "audits" => $auditQuery,
        "users" => $usersQuery
    };

    $queryResponse = mysqli_execute_query($db, $listQuery);

    if (!$queryResponse || mysqli_num_rows($queryResponse) === 0) {
        return false;
    } else {
        return $queryResponse;
    }
}

function roleNumToText($num){
    return match($num) {
        0 => "Banned",
        1 => "User",
        2 => "Moderator",
        3 => "Admin",
        4 => "Super Admin",
        default => "Unknown"
    };

}

function changeRole($db, $userID, $promotion){

}

function banUser($db, $userID){

}