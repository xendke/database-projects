<!DOCTYPE html>
<html>
<head>
<title>List sites with finder ids</title>
</head>
<body>
<?php
require("opendbo.php");
$query="SELECT * FROM sitesfinders as s JOIN finders as f where s.finderid = f.finderid  ORDER BY sdate DESC";
//$result=mysql_query($query, $link);
$result=mysqli_query($link,$query);
print("<table border='1'>");
print("<tr><th>Title</th><th>URL</th><th>Date </th><th>Description </th><th>Category </th><th>Finder </th></tr>");
//while ($row=mysql_fetch_array($result)) {
while($row=mysqli_fetch_array($result))  {
print("<tr>");
 print("<td> ".$row['stitle']."</td>");
 print ("<td><a href='".$row['surl'] ."' target='_new'>".$row['surl']."</a></td>");
 print ("<td>".$row['sdate']."</td>");
  print ("<td>".$row['sdescription']."</td>");
   print ("<td>".$row['scategory']."</td>");
   print ("<td>".$row['username']."</td>");
 print ("</tr>");
}
mysqli_close($link);
?>
</table>
</body>
</html>
