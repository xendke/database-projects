<html>
<head>
<title>Complete change finder password</title>
</head>
<body>
<?php
require("opendbo.php");
$tname = "finders";
$finder = $_POST["un"];
$epw1 = $_POST["oldpw"];
$epw2 = $_POST["newpw"];


$query = "UPDATE $tname SET epw = '$epw2' WHERE username = '$finder' AND epw = '$epw1'";

$result = mysqli_query($link, $query);
if ($result) {
	print("The password was changed.<br>\n");
}
else {
	print ("The password was NOT successfully changed. <br>\n");
}
?>
</body>
</html>
