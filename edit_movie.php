<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["userType"] !== "admin") {
    header("Location: index.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "cinemadb";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die("Invalid CSRF token");
        }

        $movieID = filter_input(INPUT_POST, 'movie_id', FILTER_SANITIZE_NUMBER_INT);
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
        $genre = filter_input(INPUT_POST, 'genre', FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $duration = filter_input(INPUT_POST, 'duration', FILTER_SANITIZE_NUMBER_INT);
        $rating = filter_input(INPUT_POST, 'rating', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $cinemaRoom = filter_input(INPUT_POST, 'cinema_room', FILTER_SANITIZE_NUMBER_INT);
        $screening = filter_input(INPUT_POST, 'screening', FILTER_SANITIZE_STRING);
        $trailer = filter_input(INPUT_POST, 'trailer', FILTER_SANITIZE_URL);

        if ($_FILES["image"]["error"] != 4) { 
            $fileName = $_FILES["image"]["name"];
            $fileSize = $_FILES["image"]["size"];
            $tmpName = $_FILES["image"]["tmp_name"];

            $validImageExtensions = ['jpg', 'jpeg', 'png'];
            $imageExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (!in_array($imageExtension, $validImageExtensions)) {
                echo "<script>alert('Invalid Image Extension');</script>";
            } elseif ($fileSize > 1000000) { 
                echo "<script>alert('Image Size Is Too Large');</script>";
            } else {
                $newImageName = uniqid() . '.' . $imageExtension;
                move_uploaded_file($tmpName, 'img/' . $newImageName);

                $sql = "UPDATE Movies SET Title=:title, Genre=:genre, Description=:description, Duration=:duration, Rating=:rating, CinemaRoom=:cinemaRoom, Screening=:screening, TrailerLink=:trailer, ImageName=:imageName WHERE MovieID=:movieID";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':imageName', $newImageName, PDO::PARAM_STR);
            }
        } else {
            $sql = "UPDATE Movies SET Title=:title, Genre=:genre, Description=:description, Duration=:duration, Rating=:rating, CinemaRoom=:cinemaRoom, Screening=:screening, TrailerLink=:trailer WHERE MovieID=:movieID";
            $stmt = $conn->prepare($sql);
        }

        
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':genre', $genre, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':duration', $duration, PDO::PARAM_INT);
        $stmt->bindParam(':rating', $rating, PDO::PARAM_STR);
        $stmt->bindParam(':cinemaRoom', $cinemaRoom, PDO::PARAM_INT);
        $stmt->bindParam(':screening', $screening, PDO::PARAM_STR);
        $stmt->bindParam(':trailer', $trailer, PDO::PARAM_STR);
        $stmt->bindParam(':movieID', $movieID, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<script>alert('Record updated successfully'); window.location.href = 'admin.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error updating record');</script>";
        }
    }

    $movieID = ($_SERVER["REQUEST_METHOD"] == "GET") ? filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT) : filter_input(INPUT_POST, 'movie_id', FILTER_SANITIZE_NUMBER_INT);
    $sql = "SELECT * FROM Movies WHERE MovieID=:movieID";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':movieID', $movieID, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        echo "<script>alert('No movie found with the provided ID');</script>";
        exit();
    }

    $title = $row['Title'];
    $genre = $row['Genre'];
    $description = $row['Description'];
    $duration = $row['Duration'];
    $rating = $row['Rating'];
    $cinemaRoom = $row['CinemaRoom'];
    $screening = $row['Screening'];
    $trailer = $row['TrailerLink'];
    $imageName = $row['ImageName'];

} catch(PDOException $e) {
    die("<script>alert('Connection failed: " . $e->getMessage() . "');</script>");
}

$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Movie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h2 class="mt-4 mb-4">Edit Movie</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="hidden" name="movie_id" value="<?php echo htmlspecialchars($movieID); ?>">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required>
            </div>
            <div class="mb-3">
                <label for="genre" class="form-label">Genre</label>
                <input type="text" class="form-control" id="genre" name="genre" value="<?php echo htmlspecialchars($genre); ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" required><?php echo htmlspecialchars($description); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="duration" class="form-label">Duration (minutes)</label>
                <input type="number" class="form-control" id="duration" name="duration" min="1" max="300" value="<?php echo htmlspecialchars($duration); ?>" required>
                <small class="text-muted">Maximum duration is 5 hours (300 minutes).</small>
            </div>
            <div class="mb-3">
                <label for="rating" class="form-label">Rating</label>
                <input type="number" class="form-control" id="rating" name="rating" min="0" max="10" step="0.1" value="<?php echo htmlspecialchars($rating); ?>" required>
                <small class="text-muted">Rating should be between 0 and 10.</small>
            </div>
            <div class="mb-3">
                <label for="cinema_room" class="form-label">Cinema Room</label>
                <select class="form-select" id="cinema_room" name="cinema_room" required>
                    <?php for ($i = 1; $i <= 7; $i++): ?>
                        <option value="<?php echo $i; ?>" <?php if ($cinemaRoom == $i) echo 'selected'; ?>>Room <?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="screening" class="form-label">Screening Date and Time</label>
                <input type="datetime-local" class="form-control" id="screening" name="screening" value="<?php echo date('Y-m-d\TH:i', strtotime($screening)); ?>" required>
            </div>
            <div class="mb-3">
                <label for="trailer" class="form-label">Trailer Link</label>
                <input type="url" class="form-control" id="trailer" name="trailer" value="<?php echo htmlspecialchars($trailer); ?>" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Change Image</label><br>
                <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="admin.php" class="btn btn-secondary">Back</a>
        </form>
        <div class="mt-4">
            <h5>Existing Image:</h5>
            <img src="img/<?php echo htmlspecialchars($imageName); ?>" alt="Movie Image" style="max-width: 200px;">
        </div>
    </div>
</body>
</html>
