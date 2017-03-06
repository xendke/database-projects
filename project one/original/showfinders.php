<html>
<head>
<title>List finders</title>
</head>
<body>
<?php
require("opendbo.php");
$query="SELECT * FROM finders";
$result=mysqli_query($link, $query);
print("<table border='1'>");
print("<tr><th>Finder's id</th><th>Name</th><th>EPW</th></tr>");
while ($row=mysqli_fetch_array($result)) {
	print ("\n");
print("<tr>");
  
  print ("<td>".$row['finderid']."</td>");
   print ("<td>".$row['username']."</td>");
   print("<td>".$row['epw']."</td>");
 print ("</tr>");
}
mysqli_close($link);
?>
</table>

</body>
</html>