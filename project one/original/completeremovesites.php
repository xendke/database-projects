<!DOCTYPE html>
<html>
<head>
<title>Delele some sites</title>
</head>
<body>
<?php
require("opendbo.php");
$un = addslashes($_POST['un']);
$epw = $_POST['pw'];
$query = "SELECT * FROM finders WHERE username='$un' AND epw='$epw'";
$result = mysqli_query($link,$query);
if ($row=mysqli_fetch_array($result)) {
$ids = $_POST['group'];
$deletelist = join (', ',$ids);
$query = "DELETE FROM sitesfinders WHERE sid IN ($deletelist)";
$result=mysqli_query($link, $query);
if ($result) {
	print ("The " . count($ids)." selected sites were deleted.");
}
else {
	print ("Problem with deletion.");
}
}
else {
	print ("Problem with username and/or password.");
}
mysqli_close($link);
?>
</body>
</html>
