<?php
$servername = "localhost";
$username = "root";  // Change to your database username
$password = "";  // Change to your database password
$dbname = "user_registration";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve and sanitize form data
$user = $_POST['username'];
$gender = $_POST['gender'];
$mobile = $_POST['mobile-number'];
$dob = $_POST['date-of-birth'];
$email = $_POST['email'];
$pass = $_POST['password'];
$confirm_pass = $_POST['confirm-password'];

// Validate passwords match
if ($pass !== $confirm_pass) {
    die("Passwords do not match.");
}

// Hash the password
$hashed_password = password_hash($pass, PASSWORD_DEFAULT);

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO users (username, gender, mobile_number, date_of_birth, email, password) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $user, $gender, $mobile, $dob, $email, $hashed_password);

if ($stmt->execute()) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

?>