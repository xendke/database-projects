<?php
function createtable($tname,$fields) {
global $DBname, $link;
$query = "DROP TABLE $tname";
mysqli_query($link,$query);
$query="CREATE TABLE ".$tname."(".$fields.")";
if (mysqli_query($link,$query)) {
   print ("The table, $tname, was created successfully.<br>\n");
   }
else {
   print ("The table, $tname, was not created. <br>\n");
   }
}
?>
<html><head><title>Creating bookmark tables </title> </head>
<body>
<?php
require("opendbo.php");
$tname = "sitesfinders";
$fields="sid INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, stitle char(50), sdate DATE, surl char(100), sdescription TEXT, scategory char(30),
finderid INT ";
createtable($tname, $fields);
$tname = "finders";
$fields = "finderid INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, username char(50), epw char(64)";
createtable($tname,$fields);
mysqli_close($link);
?>
</body>
</html>