<?php
 
 include_once "../core/connection.php";

$response = array();

session_start();
if(isset($_SESSION["user_id"])){ 
    // changed from id to user_id to match the session variable set in login.php
    //session is set
    $response["success"] = true;
    $response["id"] = $_SESSION["user_id"]; 
    //changed id to user_id to match the session variable set in login.php
    $response["user"] = $_SESSION["user"];
    $response["full_name"] = $_SESSION["fname"];
    $response["role"] = $_SESSION["role"];
     
}else{
    //session is not set
    $response["success"] = false;

}

echo json_encode($response);


?>