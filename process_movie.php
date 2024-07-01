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
    $title = htmlspecialchars($_POST['title']);
    $genre = htmlspecialchars($_POST['genre']);
    $duration = $_POST['duration'];
    $rating = $_POST['rating'];
    $cinema_room = $_POST['cinema_room'];
    $screening = $_POST['screening'];
    $trailer_link = htmlspecialchars($_POST['trailer']);
    $description = htmlspecialchars($_POST['description']);

    if ($_FILES["image"]["error"] == 4) {
        echo "<script>alert('Image not uploaded'); window.history.back();</script>";
        exit();
    } else {
        $fileName = $_FILES["image"]["name"];
        $fileSize = $_FILES["image"]["size"];
        $tmpName = $_FILES["image"]["tmp_name"];
    
        $validImageExtension = ['jpg', 'jpeg', 'png'];
        $imageExtension = explode('.', $fileName);
        $imageExtension = strtolower(end($imageExtension));
        
        if (!in_array($imageExtension, $validImageExtension)) {
            echo "<script>alert('Invalid image extension'); window.history.back();</script>";
            exit();
        } elseif ($fileSize > 1000000) {
            echo "<script>alert('Image size is too large'); window.history.back();</script>";
            exit();
        } else {
            $newImageName = uniqid() . '.' . $imageExtension;
            $uploadPath = 'img/' . $newImageName;
      
            if (!move_uploaded_file($tmpName, $uploadPath)) {
                echo "<script>alert('Failed to upload image'); window.history.back();</script>";
                exit();
            }

            $insert_sql = "INSERT INTO Movies (Title, Genre, Duration, Rating, CinemaRoom, Screening, TrailerLink, ImageName, Description)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insert_sql);
            $stmt->bind_param("ssiiissss", $title, $genre, $duration, $rating, $cinema_room, $screening, $trailer_link, $newImageName, $description);
            
            if ($stmt->execute()) {
                echo "<script>alert('New movie record created successfully'); window.location.href = 'admin.php';</script>";
            } else {
                echo "<script>alert('Error: Unable to insert movie record'); window.history.back();</script>";
            }
        }
    }
}

$conn->close();
exit();
?>
