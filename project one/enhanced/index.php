<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
  <?php
  if($_SESSION["user"] != NULL){
    $user = $_SESSION["user"];
    echo("Welcome, $user");
    echo("<a href='login.php?logout=1'>Log Out</a>\n");
  } else {
    echo("<a href='login.php'>Login</a>\n");
    echo("<a href='register.php'>Register</a>\n");
  }
  ?>
  <a href=''> </a>
  <a href=''> </a>
</body>
</html>
