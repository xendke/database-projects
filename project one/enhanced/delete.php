<?php
$_POST = json_decode(file_get_contents('php://input'), true);
$targets = $_POST['targets'];
$username = $_POST['user'];
require('database.php');

$query = "SELECT id FROM users WHERE username='$username' LIMIT 1";
$user_record = mysqli_query($conn, $query);
$user_id = mysqli_fetch_array($user_record);
$user_id = $user_id['id'];

if(empty($user_id)) {
  echo(false);
  exit();
}

foreach ($targets as $id) {
  $query = "DELETE FROM bookmarks WHERE id=$id AND user_id=$user_id";
  if (!mysqli_query($conn, $query)) {
    echo(false);
    exit();
  }
}
echo(true);
exit();
?>
