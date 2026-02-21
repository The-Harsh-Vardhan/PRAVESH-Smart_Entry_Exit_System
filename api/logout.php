<?php
session_start();
session_unset();
session_destroy();

// Clear the persistent cookie
if (isset($_COOKIE['pravesh_admin_token'])) {
	setcookie('pravesh_admin_token', '', time() - 3600, '/');
}

header("location: login.php");
?>