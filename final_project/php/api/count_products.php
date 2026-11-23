<?php

include_once "../core/connection.php";

header("Content-Type: application/json");

$result = mysqli_query($conn, "SELECT COUNT(*) AS count FROM products");

if ($result) {
    $row = mysqli_fetch_assoc($result);
    echo json_encode([
        "success" => true,
        "data" => (int) $row["count"]
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => mysqli_error($conn)
    ]);
}
?>