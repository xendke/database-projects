<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.blue_grey-light_green.min.css" />
  <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
  <!-- Always shows a header, even in smaller screens. -->
  <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
    <header class="mdl-layout__header">
      <div class="mdl-layout__header-row">
        <!-- Title -->
        <span class="mdl-layout-title"><a href="index.php" style="color: white; text-decoration: none; font-weight: normal;">Bookmarker</a></span>
        <!-- Add spacer, to align navigation to the right -->
        <div class="mdl-layout-spacer"></div>
        <!-- Navigation. We hide it in small screens. -->
        <nav class="mdl-navigation mdl-layout--large-screen-only">
          <?php
          if(!empty($_SESSION["user"])){
            $user = $_SESSION["user"];
            echo("Welcome, $user");
            echo("<a class='mdl-navigation__link' href='login.php?logout=1'>Log Out</a>\n");
          } else {
            echo("<a class='mdl-navigation__link' href='login.php'>Log In</a>\n");
            echo("<a class='mdl-navigation__link' href='register.php'>Register</a>\n");
          }
          ?>
        </nav>
      </div>
    </header>
    <div class="mdl-layout__drawer">
      <span class="mdl-layout-title">Bookmarker</span>
      <nav class="mdl-navigation">
        <?php
        if(!empty($_SESSION["user"])){
          echo("<a class='mdl-navigation__link' href='addsite.php'>New Bookmark</a>\n");
          echo("<a class='mdl-navigation__link' href='showsites.php'>Show Bookmarks</a>\n");
          echo("<a class='mdl-navigation__link' href='login.php?logout=1'>Log Out</a>\n");
        } else {
          echo("<a class='mdl-navigation__link' href='login.php'>Log In</a>\n");
          echo("<a class='mdl-navigation__link' href='register.php'>Register</a>\n");
        }
        ?>
      </nav>
    </div>
    <main class="mdl-layout__content">
      <div class="page-content">
        <!--page content goes here--> <!-- TODO if logged in dnt display card-->
        <?php
        if(empty($_SESSION['user'])){
          echo "
          <div style='padding: 120px 0;'>
          <div class='demo-card-wide mdl-card mdl-shadow--2dp' style='margin: auto; width: 75%;'>
          <div class='mdl-card__title' style=\"height: 200px; background: url('https://s-media-cache-ak0.pinimg.com/736x/6b/db/e0/6bdbe0015cd690f4ee3986bdaa1110ec.jpg') center / cover;\">
          <h2 class='mdl-card__title-text'>Welcome</h2>
          </div>
          <div class='mdl-card__supporting-text'>
          Save your favorite websites in one place.
          </div>
          <div class='mdl-card__actions mdl-card--border'>
          <a href='register.php' class='mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect'>
          Get Started
          </a>
          </div>
          <div class='mdl-card__menu'>
          <button class='mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect'>
          <i class='material-icons'>share</i>
          </button>
          </div>
          </div>
          </div>
          ";
        }
        ?>
      </div>
    </main>
  </div>
</body>
</html>
