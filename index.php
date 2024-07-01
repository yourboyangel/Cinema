<?php
session_start();

if (!isset($_SESSION['initiated'])) {
    session_regenerate_id();
    $_SESSION['initiated'] = true;
}

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    include_once 'header.php';
} else {
    include_once 'header2.php';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aniplex</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/global.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Overpass&display=swap" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="main clearfix position-relative">

<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "cinemadb";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT Title, Genre, Rating, Screening, Description, ImageName, TrailerLink FROM Movies";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$movies = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $movies[] = $row;
    }
}
$stmt->close();
$conn->close();
?>

<div class="main_2 clearfix">
<section id="center" class="center_home">
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <?php
            $randomKeys = array_rand($movies, 3);
            foreach ($randomKeys as $index => $randomKey) {
                $activeClass = $index == 0 ? 'class="active"' : '';
                echo "<button type='button' data-bs-target='#carouselExampleCaptions' data-bs-slide-to='{$index}' {$activeClass} aria-label='Slide " . ($index + 1) . "'></button>";
            }
            ?>
        </div>
        <div class="carousel-inner">
            <?php
            foreach ($randomKeys as $index => $randomKey) {
                $movie = $movies[$randomKey];
                $activeClass = $index == 0 ? 'active' : '';
                $imagePath = "img/" . htmlspecialchars($movie['ImageName']);
                echo "
                <div class='carousel-item {$activeClass}'>
                    <img src='{$imagePath}' class='d-block w-100' alt='" . htmlspecialchars($movie['Title']) . "'>
                    <div class='carousel-caption d-md-block'>
                        <h5 class='text-white-50 release ps-2 fs-6'>NEW RELEASES</h5>
                        <h1 class='font_80 mt-4'>" . htmlspecialchars($movie['Title']) . "</h1>
                        <h6 class='text-white'>
                            <span class='rating d-inline-block rounded-circle me-2 col_green'>" . htmlspecialchars($movie['Rating']) . "</span>
                            <span class='col_green'>IMDB SCORE</span>
                            <span class='mx-3'>" . htmlspecialchars($movie['Screening']) . "</span>
                            <span class='col_red'>" . htmlspecialchars($movie['Genre']) . "</span>
                        </h6>
                        <p class='mt-4'>" . htmlspecialchars($movie['Description']) . "</p>
                        <h5 class='mb-0 mt-4 text-uppercase'>
                            <a class='button' target='_blank' href='" . htmlspecialchars($movie['TrailerLink']) . "'><i class='fa fa-youtube-play me-1'></i> Watch Trailer</a>
                        </h5>
                    </div>
                </div>";
            }
            ?>
        </div>
    </div>
</section>
</div>

<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
</button>
<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
</button>
</div>
</section>
</div>

<section id="exep" class="p_3 bg-light">
<div class="container-xl">
  <div class="row exep1">
   <div class="col-md-6">
    <div class="exep1l">
      <div class="grid clearfix">
                  <figure class="effect-jazz mb-0">
                    <br><br>
                    <a href="#"><img src="img/cinema_pic.jpg" class="w-100" alt="abc"></a>
                  </figure>
              </div>
    </div>
   </div>
   <div class="col-md-6">
    <div class="exep1r">
     <h1 class="mb-0">Best pick for hassle-free streaming experience.</h1>
     <div class="exep1ri row mt-4">
      <div class="col-md-2">
       <div class="exep1ril">
        <span class="font_60"><i class="fa fa-suitcase lh-1 col_red"></i></span>
       </div>
      </div>
      <div class="col-md-10">
       <div class="exep1rir">
         <h5 class="fs-4">Multiple Locations</h5>
         <p class="mb-0">You can find us almost everywhere. We are the biggest on this country!</p>
       </div>
      </div>
     </div>
     <div class="exep1ri row mt-4">
      <div class="col-md-2">
       <div class="exep1ril">
        <span class="font_60"><i class="fa fa-desktop lh-1 col_red"></i></span>
       </div>
      </div>
      <div class="col-md-10">
       <div class="exep1rir">
         <h5 class="fs-4">High Quality Screening</h5>
         <p class="mb-0">The most modern and expensive devices are used to guarantee the best experience! IMAX wishes!</p>
       </div>
      </div>
     </div>
     <div class="exep1ri row mt-4">
      <div class="col-md-2">
       <div class="exep1ril">
        <span class="font_60"><i class="fa fa-lock lh-1 col_red"></i></span>
       </div>
      </div>
      <div class="col-md-10">
       <div class="exep1rir">
         <h5 class="fs-4">Stay secure at all times</h5>
         <p class="mb-0">Specific section to leave your personal belongings. Wanna watch a movie right after school? Yeah we can take care of them books :)</p>
       </div>
      </div>
     </div>
    </div>
   </div>
  </div>
</div>
</section>

<section id="spec" class="p_3 bg_dark">
    <div class="container-xl">
        <div class="row stream_1 text-center">
            <div class="col-md-12">
                <h1 class="mb-0 text-white font_50">Shows For You</h1>
            </div>
        </div>

        <div class="row spec_1 mt-4">
            <?php
            $conn = new mysqli($servername, $username, $password, $database);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM Movies";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-lg-2 pe-0 col-md-4">' .
                            '<div class="spec_1im clearfix position-relative">' .
                                '<div class="spec_1imi clearfix">' .
                                    '<a href="' . htmlspecialchars($row["TrailerLink"]) . '" target="_blank">' .
                                        '<img src="img/' . htmlspecialchars($row["ImageName"]) . '" class="w-100" alt="' . htmlspecialchars($row["Title"]) . '">' .
                                    '</a>' .
                                '</div>' .
                                '<div class="spec_1imi1 row m-0 w-100 h-100 clearfix position-absolute bg_col top-0">' .
                                    '<div class="col-md-9 col-9 p-0">' .
                                        '<div class="spec_1imi1l pt-2">' .
                                            '<h6 class="mb-0 font_14 d-inline-block">' .
                                                '<a class="bg-black d-block text-white" href="' . htmlspecialchars($row["TrailerLink"]) . '" target="_blank">' .
                                                    '<span class="pe-2 ps-2">1080</span>' .
                                                    '<span class="bg-white d-inline-block text-black span_2"> HD</span>' .
                                                '</a>' .
                                            '</h6>' .
                                        '</div>' .
                                    '</div>' .
                                    '<div class="col-md-3 col-3 p-0">' .
                                        '<div class="spec_1imi1r">' .
                                            '<h6 class="text-white">' .
                                                '<span class="rating d-inline-block rounded-circle me-2 col_green">' . htmlspecialchars($row["Rating"]) . '</span>' .
                                            '</h6>' .
                                        '</div>' .
                                    '</div>' .
                                '</div>' .
                            '</div>' .
                            '<div class="spec_1im1 clearfix">' .
                                '<h6 class="text-light fw-normal font_14 mt-3">' . htmlspecialchars($row["Duration"]) . ' min, <span class="col_red">' . htmlspecialchars($row["Genre"]) . '</span> <span class="span_1 pull-right d-inline-block">PG13</span></h6>' .
                                    '<a class="text-white" href="' . htmlspecialchars($row["TrailerLink"]) . '" target="_blank">' . htmlspecialchars($row["Title"]) . '</a>' .
                                '</h5>' . '<h6 class="text-light fw-normal font_14 ">' . htmlspecialchars($row["Screening"]) . '</h6>' .
                            '</div>' .
                        '</div>';
                }
            } else {
                echo "0 results";
            }
            $stmt->close();
            $conn->close();
            ?>
        </div>
    </div>
</section>

<section id="footer_b">
    <div class="container-xl">
    <div class="row footer_b1 text-center">
    <div class="col-md-12">
      <p class="mb-0 text-muted">© 2024 Aniplex. All Rights Reserved</p>
    </div>
    </div>
    </div>
</section>

<script>
window.onscroll = function() {myFunction()};

var navbar_sticky = document.getElementById("navbar_sticky");
var sticky = navbar_sticky.offsetTop;
var navbar_height = document.querySelector('.navbar').offsetHeight;

function myFunction() {
  if (window.pageYOffset >= sticky + navbar_height) {
    navbar_sticky.classList.add("sticky")
    document.body.style.paddingTop = navbar_height + 'px';
  } else {
    navbar_sticky.classList.remove("sticky");
    document.body.style.paddingTop = '0'
  }
}
</script>

</body>
</html>
