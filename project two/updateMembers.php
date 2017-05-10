<?php
/* updateMembers.php
*  add new Member(s) / edit existing Member(s) - allows for multiple member (pieces) to be updated
*
* Usage:
*   $_POST:
*     $_POST['data'] - array of Member objects.
*       [
*         {
*           id: 19, // including 'id' indicates that this Member object is reflecting changes to update an existing member
*           b_name: "Coditum", // "Coditum" will replace the data in field 'b_name' at 'id' in the table
*           city: "White Plains",
*           ...
*         },
*         { // excluding 'id' indicated that this Member object is a new Member that should be added to MM_MEMBERS
*           b_name: "Coditum",
*           city: "White Plains",
*           ...
*         },
*         ...
*       ]
*
* Response:
*   [
*    { // a response per Member object.
*     id: "",                   // id submitted / id of created Member
*     successful: true|false,   // whether no errors happened
*     message: "",
*     error: "",                // mysql errors if any
*     attempted_val: "",        // data submitted of this particular member
*     actual_val: ""            // data after execution (attempted_val if successful or actual db value if failed)
*    },
*    ...
*   ]
*
*
*/
function respond($response) {
  mysqli_close($conn);
  echo json_encode($response);
  exit;
}

require 'database.php';
session_start();

$_POST = json_decode(file_get_contents("php://input"), true);

if(!$_SESSION['is_admin']) {
  $response["message"] = "no admin permissions (try logging in as 'admin')";
  respond($response);
}

$responseArray = array();
$data = $_POST['data'];

foreach ($data as $member) {
  $responseItem = array('id'=>'', "successful"=>false, "message"=>"", "attempted_val"=>"", "actual_val"=>"");
  $target_id = $member['id'];
  $attempted_member = $member;
  $responseItem['attempted_val'] = $attempted_member;
  if(!isset($member['id']) || empty($target_id)) { // Action: Add new member
    $fields = "";
    $values = "";
    foreach ($member as $field => $value) {
      if($field === "id") { // there should be no ID any way, but...
        continue;
      }
      $fields.=$field.",";
      $parsed = is_numeric($value) ? $value : "'".$value."'";
      $values.=$parsed.",";//trim last comma $fields/$values
    }
    $fields = rtrim($fields, ",");
    $values = rtrim($values, ",");
    $query = "INSERT INTO MM_MEMBERS ($fields) VALUES ($values)";
    if(mysqli_query($conn, $query)) {// response work
      $responseItem['successful'] = true;
      $responseItem['actual_val'] = $attempted_member;
      $responseItem['id'] =  mysqli_insert_id($conn);
    } else {
      $responseItem['error'] = mysqli_error($conn);
      $responseItem['query'] = $query;
    }
  } else { // Action: edit member piece(s)
    $responseItem['id'] =  $target_id;
    $has_failed = false;
    foreach ($member as $field => $value) { // (key : value) translates to (field_name : data)
      if ($field === "id") {
        continue;
      }
      $parsed = is_numeric($value) ? $value : "'".$value."'";
      $query = "UPDATE MM_MEMBERS SET $field=$parsed WHERE MM_MEMBERS.id=$target_id";

      if(!mysqli_query($conn, $query)) { // if at least one query does not work, then the response will be a fail
        $has_failed = true;
      }
    }
    if(!$has_failed) {
      $responseItem["successful"] = true;
      $responseItem['actual_val'] = $attempted_member;
      $responseItem["message"] = "Changes on Member completed";
    } else {
      $responseItem["message"] = "Failed changing at least one Member piece";
      $actual_member = mysqli_query($conn, "SELECT * FROM MM_MEMBERS WHERE id=$target_id");
      $responseItem['actual_val'] = mysqli_fetch_assoc($actual_member);
    }
  }

  $responseArray[] = $responseItem;
}
respond($responseArray);
