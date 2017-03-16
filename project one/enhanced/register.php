<!DOCTYPE html>
<html>
<head>
</head>
<body>
  Register:
<form method="post" autocomplete="off">
  <input type="text" name="user" placeholder="username">
  <input type="password" name="pass" placeholder="password">
  <input type="submit" value="Login">
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
</body>
</html>
