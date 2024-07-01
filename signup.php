<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "cinemadb";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = htmlspecialchars($_POST['full_name']);
    $phoneNumber = htmlspecialchars($_POST['phone_number']);
    $email = htmlspecialchars($_POST['signup_email']);
    $password = $_POST['signup_password'];
    $confirmPassword = $_POST['confirm_password'];

    if (strlen($password) < 8) {
        echo "Password must be at least 8 characters long.";
        exit();
    }

    if ($password !== $confirmPassword) {
        echo "Passwords do not match.";
        exit();
    }

    $check_query = "SELECT * FROM Users WHERE Email=?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        echo "<script>alert('Email already exists.'); window.location.href = 'login.html';</script>";
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO Users (FullName, PhoneNumber, Email, PasswordHash) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $fullName, $phoneNumber, $email, $hashedPassword);

    if ($stmt->execute()) {
        header("Location: login.html");
        exit();
    } else {
        echo "Error: Unable to register user. Please try again later.";
    }

    $stmt->close();
    $check_stmt->close();
}

$conn->close();
?>
