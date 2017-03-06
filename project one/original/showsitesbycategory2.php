
<!DOCTYPE html>
<html>
<head>
<title>Show sites in selected category</title>
</head>
<body>
<?php
$scat = $_GET['pickedcategory'];
print "Sites in $scat category <br/>";
require("opendbo.php");
$query="SELECT * FROM sitesfinders as s JOIN finders as f where s.finderid = f.finderid AND scategory = '$scat' ORDER BY sdate DESC";
$result=mysqli_query($link,$query);
$NoR=mysqli_num_rows($result);
if ($NoR==0) {
	print ("No sites in that category");  }   //should never happen
else {
print("<table border='1'>");
print("<tr><th>Title</th><th>URL</th><th>Date </th><th>Description </th><th>Finder </th></tr>");
while ($row=mysqli_fetch_array($result)) {
print("<tr>");
 print("<td> ".$row['stitle']."</td>");
 print ("<td><a href='".$row['surl'] ."' target='_new'>".$row['surl']."</a></td>");
 print ("<td>".$row['sdate']."</td>");
  print ("<td>".$row['sdescription']."</td>");
  print ("<td>".$row['username']."</td>");
 print ("</tr>");
}
  print ("</table>");
}
mysqli_close($link);
?>
</body>
</html>