<?php
 include_once "../core/connection.php";

 $response = array();

 $sql = "SELECT 
    p.id,
    p.sku,
    p.name,
    p.description,
    p.unit_price,
    p.quantity,
    p.min_stock_threshold,
    p.image_path,
    p.category_id,
    c.name AS category_name,
    p.updated_at
FROM `products` p
LEFT JOIN `categories` c ON p.category_id = c.id
ORDER BY p.id ASC;";
 $result = mysqli_query($conn, $sql);

 if($result){
    $response['status'] = 1;
    $response['message'] = "Table fetched successfully";
    $response['data'] = mysqli_fetch_all($result, MYSQLI_ASSOC);
 }else{
    $response['status'] = 0;
    }
 echo json_encode($response);

?>