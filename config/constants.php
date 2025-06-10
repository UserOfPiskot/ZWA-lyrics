<?php
// Web application constants
define("WEB_NAME","Akordemon");
define("WEB_URL","https://akordemon.gigaportal.pl");
define("ASSET_PATH","/assets/");
define("COVER_PATH","/assets/uploads/covers/");
define("BASE_URL","/");

// Upload definitions
define("UPLOAD_MAX_SIZE", 2 * 1024 * 1024); // v MB
define("UPLOAD_PATH",__DIR__ . "/../public/assets/uploads/");
define("ALLOWED_IMAGE_TYPES", ["image/jpeg", /*"image/gif", "image/png", "image/webp", "image/jfif",*/ "image/jpg"]);

// Role definitions
define("SYSTEM_ROLE",5);
define("MASTER_ROLE",4);
define("ADMIN_ROLE",3);
define("MODERATOR_ROLE",2);
define("USER_ROLE",1);

// Permission levels
define("SHOW_MODERATION",MODERATOR_ROLE);
define("ADD_CONTENT",ADMIN_ROLE);
define("SHOW_FUTURE_CONTENT", MASTER_ROLE);
define("EDIT_CONTENT_FULL",ADMIN_ROLE);
/*define("ADD_CONTENT_FULL", ADMIN_ROLE);
define("VIEW_AUDITS", ADMIN_ROLE);
define("VIEW_FLAGGED", MODERATOR_ROLE);
define("PROMOTE_USERS", ADMIN_ROLE);
define("PROMOTE_MODERATORS", ADMIN_ROLE);
define("VIEW_REPORTS", MODERATOR_ROLE);
define("VIEW_SUBMISSIONS", MODERATOR_ROLE);
*/

if(!file_exists(UPLOAD_PATH . "covers")) {
    if(!mkdir(UPLOAD_PATH . "covers", 0755, true)) {
        echo "<p>Error creating covers folder!</p>";
        die(1);
    }
}