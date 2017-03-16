<?php
session_start();
if ($_GET["logout"] == 1) {
  session_unset();
  session_destroy();
  // echo("Logged Out");
  header("Location: index.php");
  exit();
} elseif ($_SESSION["user"]) {
  header("Location: index.php");
  exit();
}
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
  Log in:
  <form method="post" autocomplete="off">
    <input id="user" type="text" name="user" placeholder="username">
    <input id="pass" type="password" name="pass" placeholder="password">
    <input type="submit" value="Login">
  </form>

</body>
</html>
<?php
if($_POST["user"] == NULL) {
  return;
}
$username = addslashes($_POST['user']);
$password = $_POST['pass'];
$conn = mysqli_connect("localhost", "webuser", "password", "webdata");

if($username && $result = mysqli_query($conn, "SELECT * FROM users WHERE username=\"".$username."\" LIMIT 1")){
  if($result->num_rows == 1) { // if 0 then empty set
    $row = mysqli_fetch_array($result);
    if(password_verify($password, $row['password'])) {
      $_SESSION["user"] = $username;
      header("Location: index.php");
      exit();
    } else {
      echo("Login Failed");
    }
  } else {
    echo("Login Failed");
  }
  mysqli_free_result($result);
}

mysqli_close($conn);
?>
