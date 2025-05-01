<?php 

session_start();
require '../config/database.php';

$db = new Database();
$conn = $db->getConnection();

$_SESSION = [];
session_unset();
session_destroy();

// Redirect ke halaman login
header("Location: login.php");
exit();

?>