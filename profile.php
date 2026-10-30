<?php
session_start();
if (!isset($_SESSION["student_email"])) { header("Location: login.html"); exit; }
$students = json_decode(@file_get_contents(__DIR__ . "/data.json"), true);
if (!is_array($students)) $students = [];
$me = null;
foreach ($students as $s) if (strtolower($s["email"] ?? "") === strtolower($_SESSION["student_email"])) { $me = $s; break; }
if (!$me) { http_response_code(404); exit("Student profile not found."); }
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>My Profile - ClubJoin</title><link rel="stylesheet" href="css/style.css">  <script src="js/script.js" defer></script>
</head><body><header><h1>ClubJoin</h1><p>My Profile</p></header><nav><a href="dashboard.php">Dashboard</a><a href="clubs.html">Explore Clubs</a><a href="myclubs.php">My Joined Clubs</a><a href="logout.php">Logout</a></nav><main><h2>My Profile</h2><article><p><strong>Name:</strong> <?php echo htmlspecialchars($me["name"] ?? ""); ?></p><p><strong>Email:</strong> <?php echo htmlspecialchars($me["email"] ?? ""); ?></p><p><strong>Mobile:</strong> <?php echo htmlspecialchars($me["mobile"] ?? ""); ?></p><p><strong>Course:</strong> <?php echo htmlspecialchars($me["course"] ?? ""); ?></p><p><strong>Year:</strong> <?php echo htmlspecialchars($me["year"] ?? ""); ?></p></article></main><footer><p>&copy; 2026 ClubJoin</p></footer></body></html>
