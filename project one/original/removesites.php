<!DOCTYPE html>
<html>
<head>
<title>Delele some sites</title>
</head>
<script type="text/javascript" src="sha256.js">
</script>
<script type="text/javascript">
function encode() {
	var pw1 = document.f.pw.value;
    if ((document.f.un.value.length<1) ||(pw1.length<1)) {
		alert("Need to enter User Name and Password. Please try again.");
		return false;
	}
	else
		  {  
	    document.f.pw.value = SHA256(pw1);
	    return true;
		}
}
</script>
<body>
<?php
require("opendbo.php");
$query="SELECT * FROM sitesfinders as s JOIN finders as f where s.finderid = f.finderid  ORDER BY sdate DESC";
$result=mysqli_query($link, $query);
print("<table border='1'>");
print("<tr><th>Remove?</th><th>Name</th><th>URL</th><th>Date </th><th>Description </th><th>Category </th><th>Finder </th></tr>");
?>
<form name="f" action="completeremovesites.php" method="post" onSubmit="return encode();">
<?php
while ($row=mysqli_fetch_array($result)) {
print("<tr>");
print ("<td><input type='checkbox' name='group[]' value='".$row['sid'] . "'/></td>");
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
Username: <input name="un" type="email" required /> <br/>
Password: <input name="pw" type="password" required /> <br/>
<input type="submit" value="Delete selected sites" />
</form>
</body>
</html>
