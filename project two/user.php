<?php
/*
* Backend user system (Admins only for now)
*
* Note: When requesting to log in both $_GET and $_POST must be populated on a single request
*
* Usage:
*   $_GET: user.php?request=TYPE
*          where TYPE is "login"/"check"/"logout"
*
*   $_POST:when GET[request]=login
*          $_POST['username'] - must be "admin" to allow updateInfo
*          $_POST['password'] - not needed (lol)
*/
session_start();
//require('database.php');
header('Content-type: application/json');

$request = $_GET['request'];
$_POST = json_decode(file_get_contents("php://input"), true);

$username = $_POST['username'];

if($request === "login") {
  // TODO password_verify when needed.
  $_SESSION['username'] = $username;
  if($username == "admin") {
    $_SESSION['is_admin'] = true;
  }
  echo json_encode("LOGGED IN");
}
elseif ($request === "check") {
  echo json_encode($_SESSION['username']);
}
elseif ($request === "logout") { 
  session_unset();
  session_destroy();
  echo json_encode("LOGGED OUT");
}
else {
  echo json_encode("ERROR");
}
