<?php
/* updateMemberPiece.php
*  edit a single MM_MEMBERS piece (field)
*
* Usage:
*   $_POST:
*     $_POST['id'] - primary key (id) of record to be updated
*     $_POST['field'] - field (column) to be updated
*     $_POST['new'] - data that will replace the old data (at field and id)
*
* Response:
*   {
*     id: "",                   // id submitted / id of created category
*     successful: true|false,   // whether changes occurred
*     message: "",
*     error: "",                // mysql errors if any
*     attempted_val: "",        // $_POST['new']
*     actual_val: ""            // data after execution (attempted_val if successful or actual db value if failed)
*   }
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
$response = array('successful'=>false, 'message'=>'', 'error'=>'', 'attempted_val'=>'', 'actual_val'=>'', 'id'=>'');

$target_id = $_POST['id'];
$target_field = $_POST['field'];
$new_data = $_POST['new'];
if($id_row = mysqli_query($conn, "SELECT id FROM MM_MEMBERS WHERE id=$target_id") && mysqli_num_rows($id_row) == 1) { // found target
  $response['id'] = mysqli_fetch_row($id_row)[0];
  $parsed = is_numeric($new_data) ? $new_data : "'".$new_data."'";
  $query = "UPDATE MM_MEMBERS SET $target_field=$parsed WHERE id=$target_id";
  $response['attempted_val'] = $new_data;
  if(mysqli_query($conn, $query)) {
    $response["successful"] = true;
    $response["message"] = "Change to Member piece completed";
    $response['actual_val'] = $new_data;
  } else {
    $response["message"] = "Failed changing Member piece";
    $response['error'] = mysqli_error($conn);
    $real = mysqli_query($conn, "SELECT $target_field FROM MM_MEMBERS WHERE id=$target_id");
    $response['actual_val'] = mysqli_fetch_row($real)[0];
  }
}
respond($response);
