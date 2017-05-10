<?php
/* updateCategories.php
*    add new or edit category/categories
*
* INPUT:
*  $_POST['data']:
*   [
*     { old: "x", new: "y"}, // catgeory of name 'x' will be changed to 'y'
*     {           new: "z"}, // new 'z' category will be created
*     { old: "z", new: "w"},
*     ...
*   ]
*
*   Note: even if only one category is being added/edited it still needs to be in an indexed array
*         exampled INPUT: [{new:"new category"}]
*         'new' will be added as a new category if 'old' is empty / not submitted
*
* RESPONSE:
* [
*    {
*      successful: true|false, // whether changes occured
*      message: "",
*      error: "",              // mysql errors (if any)
*      attempted_val: "",      // data submitted
*      actual_val: "",         // data in db
*      id: ""                  // id of category targetted, empty on failed push
*    },
*    {
*      successful: true|false,
*      message: "",
*      error: "",
*      attempted_val: "",
*      actual_val: "",
*      id: ""
*    },
*    ...
* ]
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
  $responseItem["message"] = "no admin permissions (try logging in as 'admin')";
  respond($responseItem);
}

$responseArray = array();

$data = $_POST['data'];
foreach ($data as $category) {
  $responseItem = array("successful"=>false, "message"=>"", "error"=>"", "attempted_val"=>"", "actual_val"=>"");
  $target_name = $category['old'];
  $new_data = $category['new'];
  $responseItem['attempted_val'] = $category;

  if(!isset($target_name) || empty($target_name)) { // ACTION: new category
    $query = "INSERT INTO MM_CATEGORIES (name) VALUES ('$new_data')";
    if(mysqli_query($conn, $query)) {
      $responseItem["successful"] = true;
      $responseItem["message"] = "New Category added";
      $responseItem['actual_val'] = $responseItem['attempted_val']['new'];
      $id_row = mysqli_query($conn, "SELECT id FROM MM_CATEGORIES WHERE name='$new_data'");
      $responseItem['id'] = mysqli_fetch_row($id_row)[0];
    } else {
      $responseItem["message"] = "Category not added";
      $responseItem["error"] = mysqli_error($conn);
    }
  } else { // ACTION: edit category name
    $query = "SELECT id FROM MM_CATEGORIES WHERE name='$target_name'";
    $id_row = mysqli_query($conn, $query);
    if(mysqli_num_rows($id_row) == 1) { // assuming category name is unique, there should only be one
      $query = "UPDATE MM_CATEGORIES SET name='$new_data' WHERE name='$target_name'";
      if(mysqli_query($conn, $query)) {
        $responseItem["successful"] = true;
        $responseItem["message"] = "Successfully changed category name";
        $responseItem['actual_val'] = $responseItem['attempted_val']['new'];
        $responseItem['id'] = mysqli_fetch_row($id_row)[0];
      } else {
        $responseItem["message"] = "Failed changing Category name";
        $responseItem["error"] = mysqli_error($conn);
      }
    } else { // no category of name "$target_name"
        $responseItem["message"] = "No category of name: $target_name";
        $responseItem["error"] = mysqli_error($conn);
    }
  }
  $responseArray[] = $responseItem;
}
respond($responseArray);
