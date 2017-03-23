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
          echo("<a class='mdl-navigation__link' href='showsites.php'>My Bookmarks</a>\n");
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
        <div style='padding: 100px 0;'>
          <!--page content goes here--> <!-- TODO if logged in dnt display card-->
          <?php
          if(empty($_SESSION['user'])){
            ?>
            <div class='demo-card-wide mdl-card mdl-shadow--2dp' style='margin: auto; width: 75%;'>
              <div class='mdl-card__title' style="height: 200px; background: url('https://s-media-cache-ak0.pinimg.com/736x/6b/db/e0/6bdbe0015cd690f4ee3986bdaa1110ec.jpg') center / cover;">
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
            <?php
          } else {
            $username = $_SESSION['user'];
            require('database.php');
            $query = "SELECT id FROM users WHERE username='$username' LIMIT 1";
            $user_record = mysqli_query($conn, $query);
            $user_id = mysqli_fetch_array($user_record);
            $user_id = $user_id['id'];

            $query = "SELECT b.title, b.url, b.category, b.description FROM bookmarks as b RIGHT JOIN public_bookmarks as pb ON b.id=pb.bookmark_id";
            $user_record = mysqli_query($conn, $query);
            echo("<table class='mdl-data-table mdl-js-data-table mdl-data-table--selectable mdl-shadow--2dp' style='margin: auto; width: 70%;'>");
            echo("<thead><tr><th class='mdl-data-table__cell--non-numeric'>Title</th><th>URL</th><th>Category</th></tr></thead>");
            echo("<tbody>");
            while($record = mysqli_fetch_array($user_record)) {
              echo ("<tr id='".$record['title']."'>");
              echo("<td class='mdl-data-table__cell--non-numeric'>".$record['title']."</td><td><a style='color: black;' href='http://".$record['url']."'>".$record['url']."</td><td>".$record['category']."</td>");
              echo("</tr>");
              echo("<div class='mdl-tooltip' data-mdl-for='".$record['title']."'>".$record['description']."</div>");
            }
            echo("</tbody></table>");

            $username = $_SESSION['user'];

            mysqli_close($conn);
          }
          ?>
        </div>
      </div>
    </main>
    <footer class="mdl-mini-footer">
      <div class="mdl-mini-footer__left-section">
        <div class="mdl-logo">Bookmarker</div>
        <ul class="mdl-mini-footer__link-list">
          <li><a href="#">Help</a></li>
          <li><a href="#">Privacy</a></li>
        </ul>
      </div>
    </footer>
  </div>
</body>
</html>
