<?php
session_start();
if (!isset($_SESSION["student_email"])) { header("Location: login.html"); exit; }
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Student Dashboard - ClubJoin</title><link rel="stylesheet" href="css/style.css">  <script src="js/script.js" defer></script>
</head><body>
<header><h1>ClubJoin</h1><p>Student Dashboard</p></header><nav><a href="index.html">Home</a><a href="clubs.html">Explore Clubs</a><a href="myclubs.php">My Joined Clubs</a><a href="profile.php">My Profile</a><a href="logout.php">Logout</a></nav>
<main><h2>Welcome, <?php echo htmlspecialchars($_SESSION["student_name"]); ?>!</h2><p>You are logged in successfully.</p><section class="cards"><article><h3>Explore Clubs</h3><p>Find clubs that match your interests.</p><a href="clubs.html">Explore Clubs</a></article><article><h3>My Joined Clubs</h3><p>View your memberships.</p><a href="myclubs.php">View My Clubs</a></article><article><h3>My Profile</h3><p>View your student details.</p><a href="profile.php">View Profile</a></article></section></main><footer><p>&copy; 2026 ClubJoin</p></footer></body></html>
