<?php
session_start();
if (!isset($_SESSION["is_admin"]) || $_SESSION["is_admin"] !== true) { header("Location: admin-login.html"); exit; }
$file = __DIR__ . "/data.json";
$students = [];
$error = "";
if (file_exists($file)) {
 $data = json_decode(file_get_contents($file), true);
 if (is_array($data)) $students = $data; else $error = "Could not read data.json. Make sure it contains valid JSON.";
} else { $error = "data.json was not found in the ClubJoin folder."; }
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete_email"])) {
 $email = strtolower(trim($_POST["delete_email"]));
 $students = array_values(array_filter($students, function($s) use ($email) { return strtolower($s["email"] ?? "") !== $email; }));
 if (file_put_contents($file, json_encode($students, JSON_PRETTY_PRINT), LOCK_EX) === false) $error = "Unable to update data.json.";
 else { header("Location: admin-students.php?deleted=1"); exit; }
}
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Student Management - ClubJoin</title><link rel="stylesheet" href="css/style.css">  <script src="js/script.js" defer></script>
</head><body><header><h1>ClubJoin</h1><p>Student Management</p></header><nav><a href="admin-dashboard.php">Dashboard</a><a href="admin-students.php">Students</a><a href="admin-events.php">Events</a><a href="admin-logout.php">Logout</a></nav><main><h2>Registered Students</h2>
<?php if (isset($_GET["deleted"])) echo '<p class="success">Student deleted successfully.</p>'; ?>
<?php if ($error !== "") { ?><p class="error"><?php echo htmlspecialchars($error); ?></p><?php } else { ?><p>Total Students: <strong><?php echo count($students); ?></strong></p>
<?php if ($students) { ?><div class="table-wrap"><table><thead><tr><th>Name</th><th>Email</th><th>Mobile</th><th>Course</th><th>Year</th><th>Action</th></tr></thead><tbody>
<?php foreach ($students as $s) { ?><tr><td><?php echo htmlspecialchars($s["name"] ?? ""); ?></td><td><?php echo htmlspecialchars($s["email"] ?? ""); ?></td><td><?php echo htmlspecialchars($s["mobile"] ?? ""); ?></td><td><?php echo htmlspecialchars($s["course"] ?? ""); ?></td><td><?php echo htmlspecialchars($s["year"] ?? ""); ?></td><td><form method="post" onsubmit="return confirm('Delete this student?')"><input type="hidden" name="delete_email" value="<?php echo htmlspecialchars($s["email"] ?? "", ENT_QUOTES); ?>"><button class="danger" type="submit">Delete</button></form></td></tr><?php } ?>
</tbody></table></div><?php } else { ?><p>No students registered yet.</p><?php } ?><?php } ?><p><a href="admin-dashboard.php">Back to Dashboard</a></p></main><footer><p>&copy; 2026 ClubJoin</p></footer></body></html>
