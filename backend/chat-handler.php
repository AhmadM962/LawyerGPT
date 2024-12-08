<?php
session_start();
include 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the user's input message
    $user_message = $_POST['message'];

    // Call the AI backend (e.g., OpenAI API)
    $ai_response = get_ai_response($user_message); // Call to function that interacts with the API

    // Save chat message and AI response in the database
    $user_id = $_SESSION['user_id'];
    $query = "INSERT INTO chats (user_id, user_message, ai_response) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iss", $user_id, $user_message, $ai_response);
    $stmt->execute();

    // Return AI response to frontend
    echo json_encode(['ai_response' => $ai_response]);
    $stmt->close();
}

function get_ai_response($message) {
    // Simulated AI response, replace with actual API logic
    return "AI Response to: " . $message;
}
?>
