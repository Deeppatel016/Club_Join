<?php
session_start();
if (!isset($_SESSION["student_email"])) { header("Location: login.html"); exit; }
$memberships = json_decode(@file_get_contents(__DIR__ . "/memberships.json"), true);
$clubs = json_decode(@file_get_contents(__DIR__ . "/data/clubs.json"), true);
if (!is_array($memberships)) $memberships = [];
if (!is_array($clubs)) $clubs = [];
$mine = [];
foreach ($memberships as $m) {
 if (strtolower($m["email"] ?? "") !== strtolower($_SESSION["student_email"])) continue;
 foreach ($clubs as $club) {
  if (strcasecmp($club["name"] ?? "", $m["club_name"] ?? "") === 0) { $mine[] = ["club"=>$club,"date"=>$m["joined_at"] ?? ""]; break; }
 }
}
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>My Joined Clubs - ClubJoin</title><link rel="stylesheet" href="css/style.css">  <script src="js/script.js" defer></script>
</head><body><header><h1>ClubJoin</h1><p>My Joined Clubs</p></header><nav><a href="dashboard.php">Dashboard</a><a href="clubs.html">Explore Clubs</a><a href="profile.php">My Profile</a><a href="logout.php">Logout</a></nav><main><h2>My Joined Clubs</h2><p>Welcome, <?php echo htmlspecialchars($_SESSION["student_name"] ?? "Student"); ?>.</p>
<?php if (!$mine) { ?><p>You have not joined any clubs yet.</p><a href="clubs.html">Explore Clubs</a><?php } else { ?><section class="cards"><?php foreach ($mine as $item) { ?><article><h3><?php echo htmlspecialchars($item["club"]["name"] ?? ""); ?></h3><p><?php echo htmlspecialchars($item["club"]["description"] ?? ""); ?></p><p>Category: <?php echo htmlspecialchars($item["club"]["category"] ?? "Other"); ?></p><p>Joined: <?php echo htmlspecialchars($item["date"]); ?></p></article><?php } ?></section><?php } ?></main><footer><p>&copy; 2026 ClubJoin</p></footer></body></html>
