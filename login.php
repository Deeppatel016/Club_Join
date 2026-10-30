<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] !== "POST") { header("Location: login.html"); exit; }
$email = strtolower(trim($_POST["email"] ?? ""));
$password = $_POST["password"] ?? "";
$file = __DIR__ . "/data.json";
$students = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
if (!is_array($students)) $students = [];
foreach ($students as $student) {
 if (strtolower($student["email"] ?? "") === $email && password_verify($password, $student["password"] ?? "")) {
  session_regenerate_id(true);
  $_SESSION["student_email"] = $student["email"];
  $_SESSION["student_name"] = $student["name"];
  header("Location: dashboard.php"); exit;
 }
}
http_response_code(401);
echo '<!doctype html><html lang="en"><head><meta charset="utf-8"><link rel="stylesheet" href="css/style.css"><title>Login Failed</title></head><body><main><h2>Login Failed</h2><p>Incorrect email or password.</p><a href="login.html">Try Again</a></main></body></html>';
?>