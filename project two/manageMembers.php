<?php
/* manageMembers.php
*  suspend / reinstate member(s)
*
* Usage:
*     $_POST['data'] - array of MM_MEMBERS' ids
*       [
*         id,
*         id,
*         id,
*         ...
*       ]
*     $_POST['action'] - "suspend" / "reinstate" - the action to perform on all ids
*
* Response:
*    {
*     successful: true|false,   // whether no errors happened
*     message: "",
*     error: "",                // mysql errors if any
*     ids: []                   // list of ids whose status was successfully toggled (suspended/reinstated)
*    }
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

$action = $_POST['action'];
$data = $_POST['data'];
$responseItem = array('successful'=>false, 'message'=>'', 'errors'=>array(), 'ids'=>array());

$has_failed = false;
if($action === "reinstate") {
  foreach ($data as $id) {
    $query = "DELETE FROM MM_MEMBERS_S WHERE m_id=$id";

    if(mysqli_query($conn, $query)) {
      array_push($responseItem['ids'], $id);
    } else {
      $has_failed = true;
      array_push($responseItem['errors'], mysqli_error($conn));
    }
  }
} elseif ($action === "suspend") {
  foreach ($data as $id) {
    $query = "INSERT INTO MM_MEMBERS_S (m_id) VALUES ($id)";

    if(mysqli_query($conn, $query)) {
      array_push($responseItem['ids'], $id);
    } else {
      $has_failed = true;
      array_push($responseItem['errors'], mysqli_error($conn));
    }
  }
} else {
  $response["message"] = "action not recognized";
  respond($response);
}

$responseItem['successful'] = !$has_failed;
respond($responseItem);
