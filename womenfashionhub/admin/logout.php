<?php
session_start(); 
$_SESSION = array();
if (ini_get("session.use_cookies")) {
$params = session_get_cookie_params();
setcookie(session_name(), '', time() - 60*60,
$params["path"], $params["domain"],
$params["secure"], $params["httponly"]
);
}
unset($_SESSION['admin']);
unset($_SESSION['user']);
session_destroy(); // destroy session
header("location:admin/index.php"); 
?>
