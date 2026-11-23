<?php
//connects to server
$SERVER = "localhost";
//mysql user
$USER = "root";
//mysql password
$PASSWORD = "";
//database to use
$DB = "inventory_system";

$conn = mysqli_connect($SERVER, $USER, $PASSWORD, $DB);
$response = array();

if(mysqli_connect_errno()){

    $response ["success"] = false;
    $response ["message"] = mysqli_connect_error();
echo json_encode($response);
    exit();
}

?>