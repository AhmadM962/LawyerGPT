<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: sign-in.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch chats for the user
$sql = "SELECT id, chat_name, chat_history FROM chats WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='chat'>";
        echo "<h3>" . htmlspecialchars($row['chat_name']) . "</h3>";
        echo "<p>" . nl2br(htmlspecialchars($row['chat_history'])) . "</p>";
        echo "</div>";
    }
} else {
    echo "No chat history found.";
}

$stmt->close();
$conn->close();
?>
