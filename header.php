<?php
include_once "Logout.php";

if (isset($_POST['logoutButton'])) {
    logout();
}
?>
<div class="main_1 clearfix position-absolute top-0 w-100">
   <section id="header">
<nav class="navbar navbar-expand-md navbar-light" id="navbar_sticky">
  <div class="container-xl">
    <a class="navbar-brand fs-2 p-0 fw-bold text-white m-0 me-5" href="index.php"><i class="fa fa-youtube-play me-1 col_red"></i> Aniplex</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
       <ul class="navbar-nav mb-0">
        
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        </li>
         
        
        
      </ul>
      <ul class="navbar-nav mb-0 ms-auto">
          <li class="nav-item dropdown">
          
          <ul class="dropdown-menu drop_1 drop_o p-3" aria-labelledby="navbarDropdown" data-bs-popper="none">
            <li>
             
      
            </li>
          </ul>
        
          <li class="nav-item">
            <form method="POST" action="">
              <button type="submit" name="logoutButton" class="nav-link"><i class="fa fa-user fs-4 align-middle me-1 lh-1 col_red"></i> Log Out</button>
            </form>
          </li>
      </ul>
    </div>
  </div>
</nav>
</section>

 </div>
