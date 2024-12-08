<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../sign-in.html");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT first_name, last_name, email FROM users WHERE id = ?";
$stmt = $conn->prepare($query);

if (!$stmt) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}

$stmt->bind_param("i", $user_id);

if (!$stmt->execute()) {
    die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
}

$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $full_name = $user['first_name'] . ' ' . $user['last_name'];
} else {
    die("User not found.");
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <header>
        <h1>Welcome, <?php echo htmlspecialchars($full_name); ?>!</h1>
    </header>

    <main>
        <section>
            <h2>Profile Information</h2>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($full_name); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>

            <form action="update-profile.php" method="post">
    <h3>Edit Profile</h3>
    <label for="first_name">New First Name:</label>
    <input type="text" id="first_name" name="first_name" required>
    <label for="last_name">New Last Name:</label>
    <input type="text" id="last_name" name="last_name" required>
    <label for="password">New Password:</label>
    <input type="password" id="password" name="password" required>
    <button type="submit">Update Profile</button>
</form>

        </section>

        <section>
            <form action="delete-account.php" method="post">
                <button type="submit" onclick="return confirm('Are you sure you want to delete your account?');">
                    Delete Account
                </button>
            </form>
        </section>
    </main>
</body>
</html>
