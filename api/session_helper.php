<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Vercel Session Persistence Helper
 * Restores session from a cookie if the serverless environment drops it.
 */
function restore_session_if_needed()
{
    if (!isset($_SESSION['Admin-name']) && isset($_COOKIE['pravesh_admin_token'])) {
        require_once 'connectDB.php';

        $email = $_COOKIE['pravesh_admin_token'];

        $sql = "SELECT * FROM admin WHERE admin_email=?";
        $stmt = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)) {
                $_SESSION['Admin-name'] = $row['admin_name'];
                $_SESSION['Admin-email'] = $row['admin_email'];
                return true;
            }
        }
    }
    return isset($_SESSION['Admin-name']);
}

// Global requirement for all protected pages
if (!restore_session_if_needed()) {
    // If we're not on the login page, redirect
    if (basename($_SERVER['PHP_SELF']) !== 'login.php') {
        header("location: login.php");
        exit();
    }
}
?>