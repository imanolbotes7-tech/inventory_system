<?php
session_start();
// Runs on the server BEFORE the HTML is sent
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html");
    exit(); // Stops here. The HTML below is never sent to the browser.
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Admin Panel</title>
<link rel="stylesheet" href="css/style.css" />
</head>
<body>
<div class="form">
<p id="welcome-message"></p>
<a href="php/ac/logout.php">Logout</a>
</div>
</body>
</html>