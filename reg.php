<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] !== "POST") { header("Location: register.html"); exit; }
$name = trim($_POST["name"] ?? "");
$email = strtolower(trim($_POST["email"] ?? ""));
$mobile = trim($_POST["mobile"] ?? "");
$password = $_POST["password"] ?? "";
$course = trim($_POST["course"] ?? "");
$year = trim($_POST["year"] ?? "");
$terms = isset($_POST["terms"]);
$errors = [];
if (!preg_match("/^[a-zA-Z .'-]{2,80}$/", $name)) $errors[] = "Enter a valid name.";
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Enter a valid email address.";
if (!preg_match("/^[0-9]{10}$/", $mobile)) $errors[] = "Mobile number must contain exactly 10 digits.";
if (strlen($password) < 8) $errors[] = "Password must contain at least 8 characters.";
if ($course === "" || $year === "") $errors[] = "Select your course and year.";
if (!$terms) $errors[] = "Accept the terms and conditions.";
$file = __DIR__ . "/data.json";
$students = [];
if (file_exists($file)) { $decoded = json_decode(file_get_contents($file), true); if (is_array($decoded)) $students = $decoded; }
foreach ($students as $student) { if (strtolower($student["email"] ?? "") === $email) $errors[] = "This email is already registered."; }
if ($errors) { page("Registration Failed", $errors, "register.html"); exit; }
$students[] = ["name"=>$name,"email"=>$email,"mobile"=>$mobile,"password"=>password_hash($password, PASSWORD_DEFAULT),"course"=>$course,"year"=>$year];
if (file_put_contents($file, json_encode($students, JSON_PRETTY_PRINT), LOCK_EX) === false) { page("Error", ["Could not save your registration. Check folder permissions."], "register.html"); exit; }
page("Registration Successful", ["Welcome, " . $name . "! Your account has been created."], "login.html", "Go to Login");
function page($title, $messages, $link, $linkText="Go Back") {
 echo '<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>'.htmlspecialchars($title).'</title><link rel="stylesheet" href="css/style.css"></head><body><main><h2>'.htmlspecialchars($title).'</h2>';
 foreach ($messages as $m) echo '<p>'.htmlspecialchars($m).'</p>';
 echo '<p><a href="'.htmlspecialchars($link).'">'.htmlspecialchars($linkText).'</a></p></main></body></html>';
}
?>