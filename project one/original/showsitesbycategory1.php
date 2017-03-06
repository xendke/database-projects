<!DOCTYPE html>
<html>
<head>
<title>List sites in a category</title>
</head>
<body>
Pick the category you want:
<br/>
<form action="showsitesbycategory2.php" method="get">
Choices: <select name="pickedcategory">
<?php
require("opendbo.php");
$query="SELECT DISTINCT scategory FROM sitesfinders";
$categories = mysqli_query($link,$query);
while ($row=mysqli_fetch_array($categories))
{ $cat=$row['scategory'];
  print ("<option value='$cat'>$cat</option><br>\n");
}
mysqli_close($link);
?>
</select>
<input type=submit name=submit value="Choose!"> <br>
</form>
</body>
</html>