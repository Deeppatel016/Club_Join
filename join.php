<?php
session_start();
if (!isset($_SESSION["student_email"])) { header("Location: login.html"); exit; }
if ($_SERVER["REQUEST_METHOD"] !== "POST") { header("Location: clubs.html"); exit; }
$clubName = trim($_POST["club_name"] ?? "");
$clubsFile = __DIR__ . "/data/clubs.json";
$membershipFile = __DIR__ . "/memberships.json";
if ($clubName === "") { http_response_code(400); exit("Invalid club name."); }
if (!file_exists($clubsFile) || !file_exists($membershipFile)) { http_response_code(500); exit("Required data file is missing."); }
$clubs = json_decode(file_get_contents($clubsFile), true);
$memberships = json_decode(file_get_contents($membershipFile), true);
if (!is_array($clubs) || !is_array($memberships)) { http_response_code(500); exit("Unable to read data files."); }
$found = false;
foreach ($clubs as $club) { if (isset($club["name"]) && strcasecmp($club["name"], $clubName) === 0) { $clubName = $club["name"]; $found = true; break; } }
if (!$found) { http_response_code(404); exit("Club not found."); }
foreach ($memberships as $membership) {
 if (strtolower($membership["email"] ?? "") === strtolower($_SESSION["student_email"]) && strtolower($membership["club_name"] ?? "") === strtolower($clubName)) { header("Location: clubs.html?status=already_joined"); exit; }
}
$memberships[] = ["email"=>$_SESSION["student_email"], "club_name"=>$clubName, "joined_at"=>date("Y-m-d H:i:s")];
if (file_put_contents($membershipFile, json_encode($memberships, JSON_PRETTY_PRINT), LOCK_EX) === false) { http_response_code(500); exit("Unable to save membership."); }
header("Location: clubs.html?status=success"); exit;
?>