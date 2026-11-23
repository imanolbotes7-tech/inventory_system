<?php
header("Content-Type: application/json");
require_once __DIR__ . "/../core/connection.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["status" => "error", "message" => "Use POST to add a product."]);
    exit();
}

$sku = trim($_POST["sku"] ?? "");
$name = trim($_POST["name"] ?? "");
$description = trim($_POST["description"] ?? "");
$unitPrice = $_POST["unit_price"] ?? 0;
$quantity = $_POST["quantity"] ?? 0;
$minimumStock = $_POST["min_stock_threshold"] ?? 0;
$imagePath = trim($_POST["image_path"] ?? "");
$categoryInput = trim($_POST["category_id"] ?? "");

$errorMessage = "";

if ($name === "") {
    $errorMessage = "Product name is required.";
} elseif (!is_numeric($unitPrice) || $unitPrice < 0) {
    $errorMessage = "Enter a valid unit price.";
} elseif (filter_var($quantity, FILTER_VALIDATE_INT) === false || $quantity < 0) {
    $errorMessage = "Enter a valid quantity.";
} elseif (filter_var($minimumStock, FILTER_VALIDATE_INT) === false || $minimumStock < 0) {
    $errorMessage = "Enter a valid minimum stock amount.";
} elseif ($categoryInput !== "" && (!ctype_digit($categoryInput) || (int)$categoryInput < 1)) {
    $errorMessage = "Enter a valid category ID.";
}

if ($errorMessage !== "") {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => $errorMessage]);
    exit();
}

if ($categoryInput === "") {
    $categoryId = null;
} else {
    $categoryId = (int)$categoryInput;
}
$unitPrice = (float)$unitPrice;
$quantity = (int)$quantity;
$minimumStock = (int)$minimumStock;

if (!mysqli_set_charset($conn, "utf8mb4")) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
    exit();
}

$sku = mysqli_real_escape_string($conn, $sku);
$name = mysqli_real_escape_string($conn, $name);
$description = mysqli_real_escape_string($conn, $description);
$imagePath = mysqli_real_escape_string($conn, $imagePath);
if ($categoryId === null) {
    $categoryValue = "NULL";
} else {
    $categoryValue = $categoryId;
}

$sql = "INSERT INTO products
    (sku, name, description, unit_price, quantity, min_stock_threshold, image_path, category_id, updated_at)
    VALUES ('$sku', '$name', '$description', $unitPrice, $quantity, $minimumStock, '$imagePath', $categoryValue, NOW())";

if (mysqli_query($conn, $sql)) {
    $response = [
        "status" => "success",
        "message" => "Product added successfully.",
        "product_id" => mysqli_insert_id($conn)
    ];
} else {
    http_response_code(500);
    $response = ["status" => "error", "message" => mysqli_error($conn)];
}

echo json_encode($response);
