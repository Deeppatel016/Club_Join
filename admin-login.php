<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] !== "POST") { header("Location: admin-login.html"); exit; }
$username = trim($_POST["username"] ?? "");
$password = $_POST["password"] ?? "";
if ($username === "admin" && $password === "ClubJoin@123") {
 session_regenerate_id(true);
 $_SESSION["is_admin"] = true;
 header("Location: admin-dashboard.php"); exit;
}
http_response_code(401);
echo '<!doctype html><html><head><meta charset="utf-8"><link rel="stylesheet" href="css/style.css"><title>Admin Login Failed</title></head><body><main><h2>Admin Login Failed</h2><p>Incorrect username or password.</p><a href="admin-login.html">Try Again</a></main></body></html>';
?>