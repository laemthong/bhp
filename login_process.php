<?php
// Start session at the top
session_start();

// Include database connection file
include 'connect/connection.php';

// Get form data
$username = $_POST['username'];
$password = $_POST['password'];

// Encrypt the password using MD5
$hashed_password = md5($password);

// Prepare SQL statement to check user credentials
$sql = "SELECT officer_name FROM officer WHERE officer_login_name = ? AND officer_login_password_md5 = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $hashed_password);
$stmt->execute();
$result = $stmt->get_result();

// Check result
if ($result->num_rows == 1) {
    // Fetch user information
    $user = $result->fetch_assoc();
    
    // Store login status and user name in the session
    $_SESSION['login'] = $username;
    $_SESSION['user_name'] = $user['officer_name']; // Store user name in session

    // Redirect to the dashboard
    header("Location: dashboard.php");
    exit();
} else {
    // Login failed
    $_SESSION['error'] = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
    header("Location: index.php"); // Redirect back to login page
    exit();
}

// Close connection
$stmt->close();
$conn->close();
?>