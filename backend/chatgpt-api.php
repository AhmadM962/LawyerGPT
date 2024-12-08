<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../sign-in.php');
    exit();
}

$user_message = $_POST['message']; // The message sent by the user

// Prepare data for API request
$data = [
    'model' => 'gpt-3.5-turbo',
    'messages' => [
        ['role' => 'user', 'content' => $user_message]
    ]
];

// Send the request to the OpenAI API
$response = file_get_contents('https://api.openai.com/v1/chat/completions', false, stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => 'Authorization: Bearer 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',
        'content' => json_encode($data)
    ]
]));

// Decode the response
$response_data = json_decode($response, true);
$gpt_message = $response_data['choices'][0]['message']['content'];

// Store the response in the database
$user_id = $_SESSION['user_id'];
$sql = "INSERT INTO chats (user_id, message) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('is', $user_id, $gpt_message);
$stmt->execute();
$stmt->close();

echo "ChatGPT: " . htmlspecialchars($gpt_message);
?>
