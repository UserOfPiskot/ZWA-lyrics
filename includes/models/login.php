<?php

/**
 * Logs in the user by checking credentials against the database.
 *
 * @param mysqli $db            The mysqli database connection.
 * @param string $loginData     Array containing user data:
 *                              - email: User's email address.
 *                              - password: User's desired password.
 *
 * @return int Returns:
 *             1     - User logged in successfully.
 *             0     - Error logging user in (e.g., wrong password).
 */
function login($db, $loginData): int{
    $loginQuery = "
        SELECT *
        FROM users
        WHERE email = ?;
    ";

    $email = $loginData["email"];
    $password = $loginData["password"];

    $queryResponse = mysqli_execute_query($db, $loginQuery, [$email]);
    $user = mysqli_fetch_assoc($queryResponse);
    if(!$user) {
        return 0;
    }

    if(checkPassword($password, $user["passwordHash"])){
        if($user["role"] == SYSTEM_ROLE){
            return 0; // Cannot log in as system user
        }
        $_SESSION["user"] = $user;
        return 1;
    } else{
        return 0;
    }
}

/**
 * Registers the user into database.
 *
 * @param mysqli    $db         The mysqli database connection.
 * @param string $userData      Array containing user data:
 *                              - email: User's email address.
 *                              - username: User's desired username.
 *                              - password: User's desired password.
 *
 * @return int Returns:
 *             1     - User registered and logged in successfully.
 *             0     - Error registering user (e.g., email already exists).
 */
function register($db, $userData): int{
    $registerQuery = "
        INSERT INTO users (email, username, passwordHash)
        VALUES (?, ?, ?);
    ";

    $email = $userData["email"];
    $username = $userData["username"];
    $passwordHash = hashPassword($userData["password"]);

    $queryResponse = mysqli_execute_query($db, $registerQuery, [$email, $username, $passwordHash]);
    if($queryResponse){
        return login($db, $userData);
    }
    
    return 0;
}

/**
 * Changes the user's username.
 *
 * @param mysqli $db                The mysqli database connection.
 * @param string $usernameNew       New username to set.
 * @param string $password          User's password to verify ownership (plain text).
 *
 * @return int Returns:
 *             1     - Username changed successfully.
 *            -13    - Wrong password.
 *            -12    - New username is the same as the old one.
 *            -11    - Account with this username already exists.
 *            -10    - Error changing username.
 */
function changeUsername($db, $usernameNew, $password): int   {

    $findUserQuery = "
        SELECT *
        FROM users
        WHERE username = ?;
    ";

    $updateUsernameQuery = "
        UPDATE users
        SET username = ?
        WHERE username = ?;
    ";

    $usernameOld = $_SESSION["user"]["username"];

    if(!checkPassword($password, $_SESSION["user"]["passwordHash"])){
        return -13;
    }

    if($usernameOld === $usernameNew){
        return -12;
    }

    $queryResponse = mysqli_execute_query($db, $findUserQuery, [$usernameNew]);
    if($queryResponse && mysqli_num_rows($queryResponse) > 0) {
        return -11; // Username already exists
    }
    $queryResponse = mysqli_execute_query($db, $updateUsernameQuery, [$usernameNew, $usernameOld]);
    if($queryResponse){
        $_SESSION["user"]["username"] = $usernameNew;
        return 1; // Username changed successfully
    }
    
    return -10; // Error changing username
}

/**
 * Changes the user's email.
 *
 * @param mysqli    $db             The mysqli database connection.
 * @param string $emailNew          New email to set.
 * @param string $password          User's password to verify ownership (plain text).
 *
 * @return int Returns:
 *             1     - Email changed successfully.
 *            -23    - Wrong password.
 *            -22    - New email is the same as the old one.
 *            -21    - Account with this email already exists.
 *            -20    - Error changing email.
 */
function changeEmail($db, $emailNew, $password): int {
    $findUserQuery = "
        SELECT *
        FROM users
        WHERE email = ?;
    ";

    $updateEmailQuery = "
        UPDATE users
        SET email = ?
        WHERE email = ?;
    ";    
    $emailOld = $_SESSION["user"]["email"];

    if(!checkPassword($password, $_SESSION["user"]["passwordHash"])){
        return -23;
    }

    if($emailOld === $emailNew){
        return -22;
    }

    $queryResponse = mysqli_execute_query($db, $findUserQuery, [$emailNew]);
    if($queryResponse && mysqli_num_rows($queryResponse) > 0) {
        return -21; // Email already exists
    }
    $queryResponse = mysqli_execute_query($db, $updateEmailQuery, [$emailNew, $emailOld]);
    if($queryResponse){
        $_SESSION["user"]["email"] = $emailNew;
        return 1; // Email changed successfully
    }
    return -20; // Error changing email
}

/**
 * Changes the user's password.
 *
 * @param mysqli $db           The mysqli database connection.
 * @param string $passwordOld  Old password to verify ownership.
 * @param string $passwordNew  New password to set.
 *
 * @return int Returns:
 *             1     - Password changed successfully.
 *            -32    - New password is the same as the old one.
 *            -31    - Old password is incorrect.
 *            -30    - Error changing password.         
 */
function changePassword($db, $passwordOld, $passwordNew): int {
    $updatePasswordQuery = "
        UPDATE users
        SET passwordHash = ?
        WHERE email = ?;
    ";

    $email = $_SESSION["user"]["email"];
    $hashedPasswordOld = $_SESSION["user"]["passwordHash"];
    $passwordNew = hashPassword($passwordNew);

    if(checkPassword($passwordOld, $hashedPasswordOld)){
        if(checkPassword($passwordNew, $hashedPasswordOld)){
            return -32; // New password is the same as the old one
        }
        if(mysqli_execute_query($db, $updatePasswordQuery, [$passwordNew, $email])){
            $_SESSION["user"]["passwordHash"] = $passwordNew; // Update session password hash
            return 1; // Password changed successfully
        }
        return -30; // Error changing password
    }
    return -31; // Old password is incorrect
}

function deleteAccount($db, $password, $passwordConf): int {
    $deleteAccountQuery = "
        DELETE FROM users
        WHERE userID = ?;
    ";

    $hashedPasswordOld = $_SESSION["user"]["passwordHash"];
    if($password !== $passwordConf){
        return -41; // Passwords do not match
    }

    if(checkPassword($password, $hashedPasswordOld)){
        if(mysqli_execute_query($db, $deleteAccountQuery, [$_SESSION["user"]["userID"]])){
            unset($_SESSION["user"]);
            session_destroy();
            return 1; // Account deleted successfully
        }
        return -40; // Error deleting account
    }
    return -42; // Old password is incorrect
}