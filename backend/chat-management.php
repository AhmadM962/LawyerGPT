<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: sign-in.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $chat_name = $_POST['chat_name'];

    $sql = "INSERT INTO chats (user_id, chat_name, chat_history, created_at) 
            VALUES (?, ?, '', NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $user_id, $chat_name);

    if ($stmt->execute()) {
        echo "Chat created successfully.";
        // Redirect to the home page or chat page
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

