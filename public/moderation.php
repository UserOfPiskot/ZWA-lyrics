<?php
require_once __DIR__ . "/../includes/session.php";
require_once __DIR__ . "/../config/constants.php";

if(empty($_SESSION["user"])) {
    $_SESSION["error"] = "insuf.perm";
    header("Location: /");
    exit;
}

require_once __DIR__ . "/../includes/models/moderation.php";

$title = WEB_NAME;

function checkPermission($requiredRole) {
    if($_SESSION["user"]["role"] < $requiredRole) {
        $_SESSION["error"] = "insuf.perm";
        exit;
    }
}

if(empty($_GET["tab"])) {
    require_once __DIR__ . "/../views/layouts/html_head.phtml";
    require_once __DIR__ . "/../views/moderation.phtml";
    require_once __DIR__ . "/../views/layouts/html_foot.phtml";
} else {
    switch($_GET["tab"]) {
        case "reports":
            $reports = getList($conn, "reports");
            require_once __DIR__ . "/../views/moderation/reports.phtml";
            break;
        case "submissions":
            $submissions = getList($conn, "submissions");
            require_once __DIR__ . "/../views/moderation/submissions.phtml";
            break;
        case "flagged":
            $flagged = getList($conn, "flagged");
            require_once __DIR__ . "/../views/moderation/flagged.phtml";
            break;
        case "adding":
            checkPermission(ADMIN_ROLE);
            require_once __DIR__ . "/../views/moderation/adding.phtml";
            break;
        case "promote":
            checkPermission(ADMIN_ROLE);
            require_once __DIR__ . "/../views/moderation/promote.phtml";
            break;
        case "audits":
            $audits = getList($conn, "audits");
            checkPermission(ADMIN_ROLE);
            require_once __DIR__ . "/../views/moderation/audits.phtml";
            break;
        default:
            header("Location: /moderation");
            exit;
    }
}

if(!empty($_SESSION["error"]) && $_SESSION["error"] === "insuf.perm") {
    unset($_SESSION["error"]);
    echo "<script>
            window.addEventListener('DOMContentLoaded', () => {
                showToast('Inssuficient permissions!', 'error');
            });
          </script>";
}