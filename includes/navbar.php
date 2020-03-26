
<nav class="navbar navbar-expand-lg navbar-light fixed-top custom_bg py-2 px-md-5">
  <a class="navbar-brand" href="#">SCIS</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <?php if (isset($_SESSION["user_id"])) { ?> 
      <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img class="img-responsive" src="images/avatar.png" width="30px" height="30px" />
        </a>
        <div class="dropdown-menu"  aria-labelledby="navbarDropdownMenuLink">
          <!-- <a class="dropdown-item" href="#">Profile</a> -->
          <a class="dropdown-item" href="logout">Logout</a>
        </div>
      </li>
    </ul>
    <?php } ?>
  </div>
</nav>
