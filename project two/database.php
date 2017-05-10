<?php
$conn;
$dbname;

function connect_and_select() { // connect and select database
    global $conn, $dbname;
    $host = "localhost";
    $dbname = 'webdata';
    $conn = mysqli_connect($host, 'webuser', 'password');

    if(!$conn) {
        echo "Error: could not connect to host";
        die('Not connected:'. mysql_error());
    }
    if(!mysqli_select_db($conn, $dbname)) {
        echo "Error: could not select database: $dbname";
        exit;
    }
}

function exists($aname) { // returns whether app of name $aname exists or not
    global $conn;
    if(mysqli_query($conn, "SELECT * FROM users WHERE username = \"$aname\"")->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}

function drop_table($table) {
    global $conn;
    mysqli_query($conn, "DROP TABLE $table");
}

function create_table($tablename, $fields) {
    global $conn;
    drop_table($tablename);
    $query = "CREATE TABLE ".$tablename."(".$fields.")";
    if(mysqli_query($conn, $query)) {
        return true;
    } else {
        return false;
    }

}

connect_and_select();
?>
