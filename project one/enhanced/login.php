<?php
session_start();
if ($_GET["logout"] == 1) {
  session_unset();
  session_destroy();
  header("Location: index.php");
  exit();
} elseif (!empty($_SESSION["user"])) {
  header("Location: index.php");
  exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.blue_grey-light_green.min.css" />
  <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script>
  function hideChip() {
    var x = document.getElementById('chip');
    if (x.style.display === 'none') {
      x.style.display = 'block';
    } else {
      x.style.display = 'none';
    }
  }</script>
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
          <a class='mdl-navigation__link' href='login.php'>Log In</a>
          <a class='mdl-navigation__link' href='register.php'>Register</a>
        </nav>
      </div>
    </header>
    <div class="mdl-layout__drawer">
      <span class="mdl-layout-title">Bookmarker</span>
      <nav class="mdl-navigation">
        <a class="mdl-navigation__link" href="index.php">Home</a>
      </nav>
    </div>
    <main class="mdl-layout__content">
      <div class="page-content" style="margin: auto; width: 350px; padding: 140px 0;">
        <form method="post" autocomplete="off">
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
            <input class="mdl-textfield__input" id="user" type="text" name="user"><label class="mdl-textfield__label" for="user">Username</label>
          </div>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
            <input class="mdl-textfield__input" id="password" type="password" name="pass"><label class="mdl-textfield__label" for="password">Password</label>
          </div>
          <input class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent' style="width: 100%;" type="submit" value="Login">
        </form>
        <?php
        if(empty($_POST["user"]) || empty($_POST["pass"])) {
          ?>
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
          <?php
          return;
        }

        require('database.php');
        $username = addslashes($_POST['user']);
        $password = $_POST['pass'];

        if(!empty($username) && $result = mysqli_query($conn, "SELECT * FROM users WHERE username=\"".$username."\" LIMIT 1")){
          if($result->num_rows == 1) { // if 0 then empty set
            $row = mysqli_fetch_array($result);
            if(password_verify($password, $row['password'])) {
              $_SESSION["user"] = $username;
              header("Location: index.php");
              exit();
            } else {
              echo("<div style='text-align: center; padding: 40px 0;'><span class='mdl-chip mdl-chip--deletable' style='margin: auto;' id='chip'>
              <span class='mdl-chip__text'>Login Failed</span>
              <button type='button' class='mdl-chip__action' onclick='hideChip();'><i class='material-icons'>cancel</i></button>
              </span></div>");
            }
          } else {
            echo("<div style='text-align: center; padding: 40px 0;'><span class='mdl-chip mdl-chip--deletable' style='margin: auto;' id='chip'>
            <span class='mdl-chip__text'>Login Failed</span>
            <button type='button' class='mdl-chip__action' onclick='hideChip();'><i class='material-icons'>cancel</i></button>
            </span></div>");
          }
          mysqli_free_result($result);
        }

        mysqli_close($conn);
        ?>
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
