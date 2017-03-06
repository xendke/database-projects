<?php
session_start();
if(isset($_SESSION['userok']))
?>
<!DOCTYPE html>
<html>
<head>
<title>Add site</title>
</head>

<body>
<form action="addsite2.php">
Site: <input name="stitle" placeholder="Your name for site"/><br/>
Date: <input name="sdate" type="date" placeholder="YYYY-MM-DD" />   <br/>
Site description: <br/>
<textarea name="sdesc" cols="30" rows="2">
</textarea> <br/>

URL:   <input name="surl" type="url" placeholder="http://   "/><br/>
Category: <input name="scat" type="text"/><br/>
<input type="submit" value="Submit Site"/>
</form>

</body>
</html>
