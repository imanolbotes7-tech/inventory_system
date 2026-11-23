<?php 
include_once "../core/connection.php";

$user = $_POST["users"];
$pwd = $_POST["password_hash"];
$pwd = md5($pwd);

$sql = "SELECT * FROM users WHERE 
        email = '$user' AND 
        password_hash = '$pwd'";

$qry = mysqli_query($conn, $sql);
if(mysqli_num_rows($qry)>0){
    session_start();

    $row = mysqli_fetch_assoc($qry);
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['role'] = $row['role'];
    $_SESSION["user"]=$row["email"];
    $_SESSION["fname"]=$row["full_name"];

    $response["success"] = true;
    $response["role"] = $row["role"];
}else{
    $response["success"] = false;
}
echo json_encode($response);
?>