<?php
session_start();

$servername = "localhost";
$username = "root";
$database = "cinemadb";

$conn = new mysqli($servername, $username, "", $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['login_email'];
    $password = $_POST['login_password'];

    $sql = "SELECT * FROM Users WHERE Email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['PasswordHash'];
        $userType = $row['UserType'];

        if (password_verify($password, $hashedPassword)) {
            $_SESSION['loggedin'] = true;
            $_SESSION['userType'] = $userType;

            session_regenerate_id(true);

            if ($userType == 'admin') {
                header("Location: admin.php");
                exit();
            } else {
                header("Location: index.php");
                exit();
            }
        } else {
            redirectToLogin("Invalid email or password.");
        }
    } else {
        redirectToLogin("Invalid email or password.");
    }
}

function redirectToLogin($message) {
    echo "<script>alert('$message'); window.location.href = 'login.html';</script>";
    exit();
}

$conn->close();
?>
