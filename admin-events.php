<?php
session_start();
if (!isset($_SESSION["is_admin"]) || $_SESSION["is_admin"] !== true) { header("Location: admin-login.html"); exit; }
$file = __DIR__ . "/events.json";
$events = [];
if (file_exists($file)) { $d = json_decode(file_get_contents($file), true); if (is_array($d)) $events = $d; }
$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
 if (isset($_POST["delete_id"])) {
  $id = (string)$_POST["delete_id"];
  $events = array_values(array_filter($events, function($e) use ($id) { return (string)($e["id"] ?? "") !== $id; }));
 } else {
  $title = trim($_POST["title"] ?? "");
  $club = trim($_POST["club"] ?? "");
  $date = trim($_POST["event_date"] ?? "");
  $description = trim($_POST["description"] ?? "");
  if ($title === "" || $club === "" || $date === "") $error = "Please enter event title, club and date.";
  else $events[] = ["id" => uniqid("evt_"), "title" => $title, "club" => $club, "event_date" => $date, "description" => $description];
 }
 if ($error === "") { file_put_contents($file, json_encode($events, JSON_PRETTY_PRINT), LOCK_EX); header("Location: admin-events.php?saved=1"); exit; }
}
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Event Management - ClubJoin</title><link rel="stylesheet" href="css/style.css">  <script src="js/script.js" defer></script>
</head><body><header><h1>ClubJoin</h1><p>Event Management</p></header><nav><a href="admin-dashboard.php">Dashboard</a><a href="admin-students.php">Students</a><a href="admin-events.php">Events</a><a href="admin-logout.php">Logout</a></nav><main><h2>Add an Event</h2><?php if ($error) echo '<p class="error">'.htmlspecialchars($error).'</p>'; if (isset($_GET["saved"])) echo '<p class="success">Changes saved successfully.</p>'; ?>
<form method="post"><label for="title">Event title</label><input id="title" name="title" required><label for="club">Club name</label><input id="club" name="club" required><label for="event_date">Event date</label><input type="date" id="event_date" name="event_date" required><label for="description">Description</label><textarea id="description" name="description" rows="3"></textarea><button type="submit">Add Event</button></form>
<h2>Events</h2><?php if (!$events) { ?><p>No events added yet.</p><?php } else { ?><section class="cards"><?php foreach ($events as $e) { ?><article><h3><?php echo htmlspecialchars($e["title"] ?? ""); ?></h3><p>Club: <?php echo htmlspecialchars($e["club"] ?? ""); ?></p><p>Date: <?php echo htmlspecialchars($e["event_date"] ?? ""); ?></p><p><?php echo htmlspecialchars($e["description"] ?? ""); ?></p><form method="post" onsubmit="return confirm('Delete this event?')"><input type="hidden" name="delete_id" value="<?php echo htmlspecialchars($e["id"] ?? "", ENT_QUOTES); ?>"><button class="danger" type="submit">Delete Event</button></form></article><?php } ?></section><?php } ?></main><footer><p>&copy; 2026 ClubJoin</p></footer></body></html>
