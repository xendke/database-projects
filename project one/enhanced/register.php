<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-purple.min.css" />
  <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
</head>
<body>
  <!-- Always shows a header, even in smaller screens. -->
  <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
    <header class="mdl-layout__header">
      <div class="mdl-layout__header-row">
        <!-- Title -->
        <span class="mdl-layout-title">Bookmarker</span>
        <!-- Add spacer, to align navigation to the right -->
        <div class="mdl-layout-spacer"></div>
        <!-- Navigation. We hide it in small screens. -->
        <nav class="mdl-navigation mdl-layout--large-screen-only">
          <a class='mdl-navigation__link' href='register.php'>Register</a>
        </nav>
      </div>
    </header>
    <div class="mdl-layout__drawer">
      <span class="mdl-layout-title">Title</span>
      <nav class="mdl-navigation">
        <a class="mdl-navigation__link" href="index.php">Home</a>
      </nav>
    </div>
    <main class="mdl-layout__content">
      <div class="page-content" style="margin: auto; width: 50%; height: 50%; padding: 70px 0;">
        <form method="post" autocomplete="off">
          <div class="mdl-textfield mdl-js-textfield">
            <input class="mdl-textfield__input" id="user" type="text" name="user"><label class="mdl-textfield__label" for="user">Username</label>
          </div>
          <div class="mdl-textfield mdl-js-textfield">
            <input class="mdl-textfield__input" id="password" type="password" name="pass"><label class="mdl-textfield__label" for="password">Password</label>
          </div>
          <input class='mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--primary' type="submit" value="Register">
        </form>
        <?php
        if(!$_POST["user"]){ // if input "user" is empty dont execute the rest of the code
          return;
        }
        $username = addslashes($_POST['user']);
        $password = $_POST['pass'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $conn = mysqli_connect("localhost", "webuser", "password", "webdata");

        $query = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
        mysqli_query($conn, $query);
        mysqli_close($conn);
        header("Location: login.php");
        exit();
        ?>
      </div>
    </main>
  </div>
</body>
</html>
