<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: sign-in.php');
    exit();
}

$user_id = $_SESSION['user_id']; // Get user ID from session
?>
