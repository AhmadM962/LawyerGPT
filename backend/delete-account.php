<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: sign-in.php');
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "DELETE FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);

if ($stmt->execute()) {
    session_destroy();  // End the session after deleting the account
    header('Location: sign-in.php');  // Redirect to the sign-in page in the same folder
    exit();
} else {
    echo "Error deleting account: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
