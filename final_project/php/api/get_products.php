<?php

 include_once "../core/connection.php";

 $response = array();

 $sql = "SELECT * FROM products";
 $result = mysqli_query($conn, $sql);

 if($result){
    $response['status'] = 1;
    $response['message'] = "Products fetched successfully";
    $response['data'] = mysqli_fetch_all($result, MYSQLI_ASSOC);
 }else{
    $response['status'] = 0;
    }
 echo json_encode($response);

?>