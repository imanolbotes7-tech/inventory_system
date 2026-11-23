<?php
header("Content-Type: application/json");
require_once __DIR__ . "/../core/connection.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Use POST to delete a product."]);
    exit();
}

$productId = $_POST["id"] ?? "";
if (filter_var($productId, FILTER_VALIDATE_INT) === false || (int)$productId < 1) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "A valid product ID is required."]);
    exit();
}

$statement = mysqli_prepare($conn, "DELETE FROM products WHERE id = ?");
if (!$statement) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
    exit();
}

$productId = (int)$productId;
mysqli_stmt_bind_param($statement, "i", $productId);

if (!mysqli_stmt_execute($statement)) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => mysqli_stmt_error($statement)
    ]);
} elseif (mysqli_stmt_affected_rows($statement) === 0) {
    http_response_code(404);
    echo json_encode(["status" => "error", "message" => "Product was not found."]);
} else {
    echo json_encode(["status" => "success", "message" => "Product deleted."]);
}

mysqli_stmt_close($statement);
