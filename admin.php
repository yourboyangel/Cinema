<?php

session_start();


if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["userType"] !== "admin") {
    header("Location: index.php");
    exit();
}

include_once "Logout.php";

if (isset($_GET['logout'])) {
    logout();
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
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}


$stmt = $conn->prepare("SELECT * FROM Movies");
$stmt->execute();

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

$conn = null; 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="admin.php">Aniplex</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="?logout=true">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="admin.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            View Movies
                        </a>
                        <div class="sb-sidenav-menu-heading">Actions</div>
                        <a class="nav-link collapsed" href="#" id="addMovieLink">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Add Movie
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    Admin
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Admin Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Cinema Dashboard</li>
                    </ol>

                    <div id="addMovieForm" style="display: none;" class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-film me-1"></i>
                            Add Movie
                        </div>
                        <div class="card-body">
                            <form action="process_movie.php" method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>
                                <div class="mb-3">
                                    <label for="genre" class="form-label">Genre</label>
                                    <input type="text" class="form-control" id="genre" name="genre" required>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="duration" class="form-label">Duration (minutes)</label>
                                    <input type="number" class="form-control" id="duration" name="duration" min="1" max="300" required>
                                    <small class="text-muted">Maximum duration is 5 hours (300 minutes).</small>
                                </div>
                                <div class="mb-3">
                                    <label for="rating" class="form-label">Rating</label>
                                    <input type="number" class="form-control" id="rating" name="rating" min="0" max="10" step="0.1" required>
                                    <small class="text-muted">Rating should be between 0 and 10.</small>
                                </div>
                                <div class="mb-3">
                                    <label for="cinema_room" class="form-label">Cinema Room</label>
                                    <select class="form-select" id="cinema_room" name="cinema_room" required>
                                        <option selected disabled>Select Cinema Room</option>
                                        <option value="1">Room 1</option>
                                        <option value="2">Room 2</option>
                                        <option value="3">Room 3</option>
                                        <option value="4">Room 4</option>
                                        <option value="5">Room 5</option>
                                        <option value="6">Room 6</option>
                                        <option value="7">Room 7</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="screening" class="form-label">Screening Date and Time</label>
                                    <input type="datetime-local" class="form-control" id="screening" name="screening" required>
                                </div>
                                <div class="mb-3">
                                    <label for="trailer" class="form-label">Trailer Link</label>
                                    <input type="text" class="form-control" id="trailer" name="trailer" required>
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Insert Image</label><br>
                                    <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png">
                                </div><br>
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                            </form>
                        </div>
                    </div>

                    <div id="moviesTable" class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Movies
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Genre</th>
                                        <th>Duration</th>
                                        <th>Rating</th>
                                        <th>Room</th>
                                        <th>Screening</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Title</th>
                                        <th>Genre</th>
                                        <th>Duration</th>
                                        <th>Rating</th>
                                        <th>Room</th>
                                        <th>Screening</th>
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    foreach ($data as $row) {
                                        $title = htmlspecialchars($row['Title'], ENT_QUOTES, 'UTF-8');
                                        $genre = htmlspecialchars($row['Genre'], ENT_QUOTES, 'UTF-8');
                                        $duration = htmlspecialchars($row['Duration'], ENT_QUOTES, 'UTF-8');
                                        $rating = htmlspecialchars($row['Rating'], ENT_QUOTES, 'UTF-8');
                                        $cinemaRoom = htmlspecialchars($row['CinemaRoom'], ENT_QUOTES, 'UTF-8');
                                        $screening = htmlspecialchars($row['Screening'], ENT_QUOTES, 'UTF-8');
                                        $movieID = htmlspecialchars($row['MovieID'], ENT_QUOTES, 'UTF-8');
                                        $trailerLink = htmlspecialchars($row['TrailerLink'], ENT_QUOTES, 'UTF-8');
                                        $description=htmlspecialchars($row['Description'], ENT_QUOTES, 'UTF-8');
                                        echo "<tr>
                                            <td>{$title}</td>
                                            <td>{$genre}</td>
                                            <td>{$duration}</td>
                                            <td>{$rating}</td>
                                            <td>{$cinemaRoom}</td>
                                            <td>{$screening}</td>
                                            <td>
                                                <button type='button' class='btn btn-info btn-sm' data-bs-toggle='modal' data-bs-target='#movieModal{$movieID}'>View</button>
                                                <a href='edit_movie.php?id={$movieID}' class='btn btn-warning btn-sm'>Edit</a>
                                                <a href='delete_movie.php?id={$movieID}" . "' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure you want to delete this movie?');\">Delete</a>
                                            </td>
                                        </tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>

            <?php
            foreach ($data as $movie) {
                $imagePath = "img/" . ($movie['ImageName']); 
                echo <<<HTML
                    <div class="modal fade" id="movieModal{$movie['MovieID']}" tabindex="-1" aria-labelledby="movieModalLabel{$movie['MovieID']}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="movieModalLabel{$movie['MovieID']}">{$movie['Title']}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <img src="{$imagePath}" class="img-fluid" alt="{$movie['Title']}">
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Genre:</strong> {$movie['Genre']}</p>
                                            <p><strong>Duration:</strong> {$movie['Duration']} minutes</p>
                                            <p><strong>Rating:</strong> {$movie['Rating']}</p>
                                            <p><strong>Cinema Room:</strong> {$movie['CinemaRoom']}</p>
                                            <p><strong>Screening:</strong> {$movie['Screening']}</p>
                                            <p><strong>Trailer:</strong> <a href="{$movie['TrailerLink']}" target="_blank">Watch Trailer</a></p>
                                            <p><strong>Description:</strong>{$movie['Description']}</p>

                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                HTML;
            }
            ?>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script>
        document.getElementById("addMovieLink").addEventListener("click", function() {
            var form = document.getElementById("addMovieForm");
            if (form.style.display === "none") {
                form.style.display = "block";
            } else {
                form.style.display = "none";
            }
        });
    </script>
</body>

</html>

