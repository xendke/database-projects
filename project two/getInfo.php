<?php
/*
* Get information on MM_CATEGORIES, MM_MEMBERS, and MM_MEMBERS_S
*
* Usage: getInfo.php?request=TYPE
*        where TYPE is "active", "suspended", "categories"
*
* Response: Array { // indexed
*             0: { // associative
*               fieldname: "data",
*               ...
*             }
*             ...
*           }
*/
require('database.php');
header('Content-type: application/json');

$request = $_GET['request'];
if($request === "categories") { # return only categories used by Member records
  $query = "SELECT DISTINCT c.* FROM MM_CATEGORIES as c INNER JOIN MM_MEMBERS as m ON  c.id = m.p_cat or c.id = m.s_cat or c.id = m.t_cat";
}
elseif ($request === "all_categories") { # returns all categories possible
  $query = "SELECT * FROM MM_CATEGORIES";
}
elseif ($request === "active") { # active members ( not in MM_MEMBERS_S table )
  $query =
  "SELECT m.*, pc.name as p_cat, sc.name as s_cat, tc.name as t_cat
  FROM MM_MEMBERS as m
    LEFT JOIN MM_MEMBERS_S as sm ON m.id = sm.m_id
    LEFT JOIN MM_CATEGORIES as pc ON pc.id = m.p_cat
    LEFT JOIN MM_CATEGORIES as sc ON sc.id = m.s_cat
    LEFT JOIN MM_CATEGORIES as tc ON tc.id = m.t_cat
  WHERE sm.m_id IS NULL";
  //$query = "SELECT m.* FROM MM_MEMBERS as m LEFT JOIN MM_MEMBERS_S as sm ON sm.m_id=m.id WHERE sm.m_id IS NULL";
}
elseif ($request === "suspended") { # members in MM_MEMBERS_S table
  $query = "SELECT m.*, pc.name as p_cat, sc.name as s_cat, tc.name as t_cat, sm.id as s_id
  FROM MM_MEMBERS as m
  RIGHT JOIN MM_MEMBERS_S as sm ON m.id = sm.m_id
  LEFT JOIN MM_CATEGORIES as pc ON pc.id = m.p_cat
  LEFT JOIN MM_CATEGORIES as sc ON sc.id = m.s_cat
  LEFT JOIN MM_CATEGORIES as tc ON tc.id = m.t_cat";
}
else {
  echo json_encode("Invalid Request");
  mysqli_close($conn);
  exit;
}

$result = mysqli_query($conn, $query);
$rows = array(); # array that will hold all the records of $result for json encoding.
while($r = mysqli_fetch_assoc($result)) {
  $rows[] = $r;
}
echo json_encode($rows);
mysqli_close($conn);
