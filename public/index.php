<?php
require_once __DIR__ . "/../includes/session.php";
require_once __DIR__ . "/../config/constants.php";

$title = WEB_NAME;

require_once __DIR__ . "/../views/layouts/html_head.phtml";
require_once __DIR__ . "/../views/index.phtml";
require_once __DIR__ . "/../views/layouts/html_foot.phtml";

if(!empty($_SESSION["error"]) && $_SESSION["error"] === "insuf.perm") {
    unset($_SESSION["error"]);
    echo "<script>
            window.addEventListener('DOMContentLoaded', () => {
                showToast('Insufficient permissions!', 'error');
            });
          </script>";
}