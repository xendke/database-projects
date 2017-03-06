<html>
<head>
<title>Complete registering finder</title>
</head>
<body>
<?php
require("opendbo.php");
$tname = "finders";
$finder = $_POST["un"];
$epw = $_POST["pw"];
$query = "INSERT INTO $tname values ('0','$finder','$epw')";
$result = mysqli_query($link, $query);
if ($result) {
	print("The finder was successfully added.<br>\n");
}
else {
	print ("The finder was NOT successfully added. <br>\n");
}
?>
</body>
</html>
