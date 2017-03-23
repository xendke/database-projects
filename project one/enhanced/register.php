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
  <script src='https://www.google.com/recaptcha/api.js'></script>
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
      <div class="page-content">
        <form method="post" autocomplete="off" style="margin: auto; width: 350px; padding: 40px 0;">
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
            <input class="mdl-textfield__input" id="user" type="text" name="user">
            <label class="mdl-textfield__label" for="user">Username</label>
          </div><br>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
            <input class="mdl-textfield__input" id="password" pattern="^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$" type="password" name="pass">
            <label class="mdl-textfield__label" for="password">Password</label>
            <span class="mdl-textfield__error">At least 1 number, 1 uppercase, 1 lowercase, and 8 characters needed.</span>
          </div><br>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%">
            <input class="mdl-textfield__input" type="text" pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" id="email" name="email">
            <label class="mdl-textfield__label" for="email">Email</label>
            <span class="mdl-textfield__error">Invalid Email</span>
          </div>
          <div style="margin: 0 auto; display: block; width: 304px; padding: 30px;" class="g-recaptcha" data-sitekey="6LeQ5hkUAAAAADk7uw6KbIlWDkOYuXJfN5wc9RL2"></div>
          <input style="width: 100%;" class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent' name='submit' type="submit" value="Register">
        </form>
        <?php
        function clean_exit() {
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
  exit;
        }

        if(!isset($_POST['submit']) && empty($_POST['submit'])) {
          clean_exit();
        }
        if(empty($_POST["user"]) || empty($_POST["pass"]) || empty($_POST["email"])){ // stop if required fields were empty
          ?>
          <div style='text-align: center; padding: 0px 0;'><span class='mdl-chip mdl-chip--deletable' style='margin: auto;' id='chip'>
            <span class='mdl-chip__text'>All fields are required</span>
            <button type='button' class='mdl-chip__action' onclick='hideChip();'><i class='material-icons'>cancel</i></button>
          </span></div>
          <?php
          clean_exit();
        }

        require_once('recaptchalib.php');
        $secret = "6LeQ5hkUAAAAAF5b8t7o7o2UDqfZ3Alg5-hH0pDH";
        $response = null;
        $reCaptcha = new ReCaptcha($secret);
        if (isset($_POST["g-recaptcha-response"]) && !empty($_POST['g-recaptcha-response'])) {

          $response = $reCaptcha->verifyResponse(
            $_SERVER["REMOTE_ADDR"],
            $_POST["g-recaptcha-response"]
          );
          if ($response != null && $response->success) {

          } else {
            ?>
            <div style='text-align: center; padding: 40px 0;'><span class='mdl-chip mdl-chip--deletable' style='margin: auto;' id='chip'>
              <span class='mdl-chip__text'>Are you a robot?</span>
              <button type='button' class='mdl-chip__action' onclick='hideChip();'><i class='material-icons'>cancel</i></button>
            </span></div>
            <?php
            exit;
          }
        }
        else{
          ?>
          <div style='text-align: center; padding: 40px 0;'><span class='mdl-chip mdl-chip--deletable' style='margin: auto;' id='chip'>
            <span class='mdl-chip__text'>Are you a robot?</span>
            <button type='button' class='mdl-chip__action' onclick='hideChip();'><i class='material-icons'>cancel</i></button>
          </span></div>
          <?php
          exit;
        }

        require('database.php');
        $username = addslashes($_POST['user']);
        $password = $_POST['pass'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $email = $_POST['email'];

        $query = "INSERT INTO users (username, password, email) VALUES ('$username', '$hashed_password', '$email')";
        if(mysqli_query($conn, $query)){
          mysqli_close($conn);
          header("Location: login.php");
          exit();
        } else {
          ?>
          <div style='text-align: center; padding: 40px 0;'><span class='mdl-chip mdl-chip--deletable' style='margin: auto;' id='chip'>
            <span class='mdl-chip__text'>Username already exists.</span>
            <button type='button' class='mdl-chip__action' onclick='hideChip();'><i class='material-icons'>cancel</i></button>
          </span></div>
          <?php
        }
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
