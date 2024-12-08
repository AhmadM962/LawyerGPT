<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../sign-in.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $new_first_name = $_POST['first_name'];
    $new_last_name = $_POST['last_name'];
    $new_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = "UPDATE users SET first_name = ?, last_name = ?, password = ? WHERE id = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }

    $stmt->bind_param("sssi", $new_first_name, $new_last_name, $new_password, $user_id);

    if (!$stmt->execute()) {
        die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
    }

    $stmt->close();
    $conn->close();

    header("Location: dashboard.php?success=profile_updated");
    exit();
} else {
    header("Location: dashboard.php?error=invalid_request");
    exit();
}
?>
