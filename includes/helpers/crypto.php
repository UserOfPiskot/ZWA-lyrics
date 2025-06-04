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