<?php

/**
 * Compares a plain text password with a hashed one.
 *
 * @param string $password         Password string (plain text).
 * @param string $passwordHash     Password string (hashed).
 *
 * @return bool Returns true if passwords match.
 */
function checkPassword($password, $passwordHash): bool{
    return password_verify($password, $passwordHash);
}

/**
 * Hashed a plaintext password with current hashing algorithm.
 *
 * @param string $password         Password string (plain text).
 *
 * @return string Returns a hashed password.
 */
function hashPassword($password): string{
    //$passwordHash = hash("sha256", $password. ":" . $salt . ":" . getPepper());
    return password_hash($password, PASSWORD_DEFAULT);
}

function fill($arr): mysqli_result|array {
    if($arr === false) {
        return $arr = [];
    }
    return $arr;
}

function buildImagePath($artist, $cover): string {
    return COVER_PATH . $artist . "/" . $cover . ".jpg";
}

function convertNewLinesToBr($text): string {
    return nl2br(htmlspecialchars($text, ENT_QUOTES, 'UTF-8'));
}

function slugify($text): string {
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9-]+/', '-', $text);
    $text = preg_replace('/-+/', '-', $text);
    return rtrim($text, '-');
}

function popup($message, $type): void {
    echo "<script>
            window.addEventListener('DOMContentLoaded', () => {
                showToast('" . $message . "', '" . $type . "');
            });
        </script>";
}

function fileMover($folder, $id, $name): bool {
    if($_FILES["coverID"]["error"] == 0){
        if(in_array($_FILES["coverID"]["type"], ALLOWED_IMAGE_TYPES)){
            if($_FILES["coverID"]["size"] <= UPLOAD_MAX_SIZE){
                move_uploaded_file($_FILES["coverID"]["tmp_name"],
                UPLOAD_PATH . $folder . $id . "/" .  $name . ".jpg");
                return true;
            } else {
                echo "1";
                popup("File too large!", "error");
            }
        } else {
            echo "2";
            popup("Wrong file type!", "error");
        }
    } else {
        switch($_FILES["coverID"]["error"]){
            case 1:
                popup("Size of file exceeds ini upload limit!", "error");
                break;
            case 2:
                popup("Size of file exceeds html upload limit!", "error");
                break;
            case 3:
                popup("Only part of the file was uploaded!", "error");
                break;
            case 4:
                popup("File was not uploaded due to error!", "error");
                break;
            case 6:
                popup("No TEMP folder!", "error");
                break;
            case 7:
                popup("Error while writing to disk!", "error");
                break;
            case 8:
                popup("<p>File upload was cancelled by PHP extension!", "error");
                break;
            default:
                popup("Unknown upload error!", "error");
        }
    }
    return false;
}
