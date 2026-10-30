<?php
session_start();
if (!isset($_SESSION["is_admin"]) || $_SESSION["is_admin"] !== true) { header("Location: admin-login.html"); exit; }
function readJsonFile($path) { if (!file_exists($path)) return []; $x = json_decode(file_get_contents($path), true); return is_array($x) ? $x : []; }
$students = readJsonFile(__DIR__ . "/data.json");
$clubs = readJsonFile(__DIR__ . "/data/clubs.json");
$memberships = readJsonFile(__DIR__ . "/memberships.json");
$events = readJsonFile(__DIR__ . "/events.json");
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Admin Dashboard - ClubJoin</title><link rel="stylesheet" href="css/style.css">  <script src="js/script.js" defer></script>
</head><body><header><h1>ClubJoin</h1><p>Admin Dashboard</p></header><nav><a href="admin-dashboard.php">Dashboard</a><a href="admin-students.php">Students</a><a href="admin-events.php">Events</a><a href="clubs.html">Clubs</a><a href="admin-logout.php">Logout</a></nav><main><h2>Welcome, Administrator!</h2><section class="cards"><article><h3>Total Students</h3><p class="number"><?php echo count($students); ?></p><a href="admin-students.php">Manage Students</a></article><article><h3>Total Clubs</h3><p class="number"><?php echo count($clubs); ?></p><a href="clubs.html">View Clubs</a></article><article><h3>Total Memberships</h3><p class="number"><?php echo count($memberships); ?></p></article><article><h3>Total Events</h3><p class="number"><?php echo count($events); ?></p><a href="admin-events.php">Manage Events</a></article></section></main><footer><p>&copy; 2026 ClubJoin</p></footer></body></html>
