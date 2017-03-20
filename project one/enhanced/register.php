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
        <form method="post" autocomplete="off" style="margin: auto; width: 30%; padding: 70px 0;">
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
          </div><br>
          <input style="width: 100%;" class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent' type="submit" value="Register">
        </form>
        <?php
        if(empty($_POST["user"]) || empty($_POST["pass"]) || empty($_POST["email"])){ // stop if required fields were empty
          // echo error;
          return;
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
          echo ("Username or Email is already registered.");
        }
        ?>
      </div>
    </main>
  </div>
</body>
</html>
