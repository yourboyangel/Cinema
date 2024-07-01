<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["userType"] !== "admin") {
    header("Location: index.php");
    exit();
}


if(isset($_GET['id'])) {
    $movieID = intval($_GET['id']);

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "cinemadb";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "DELETE FROM Movies WHERE MovieID = :movieID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':movieID', $movieID, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: admin.php");
            exit();
        } else {
            echo "Error deleting record.";
        }
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
} else {
    header("Location: admin.php");
    exit();
}
?>
