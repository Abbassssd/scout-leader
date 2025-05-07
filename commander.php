<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'leader4') {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "scout");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userId = $_SESSION['user_id'];

// Fetch Commander Info (assume commander is in admins table)
$stmt = $conn->prepare("SELECT username FROM admins WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$commander = $result->fetch_assoc();
$stmt->close();

// Fetch All Leaders
$leaders = $conn->query("SELECT id, first_name, last_name, type_of_account FROM admins WHERE type_of_account IN ('cubs', 'junior', 'youth')");

// Fetch Schedule for commander

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Commander Dashboard - Lebanon Scout</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: url('assets/img/hero-bg-2.jpg') no-repeat center center fixed;
      background-size: cover;
    }
    .sidebar {
      background: #ffe627;
      padding: 20px;
      height: 100vh;
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    .nav-link { color:rgb(90, 24, 154); }
    .nav-link.active { background-color: #fff; font-weight: bold; border-radius: 8px; }
    .content-area {
      padding: 30px;
      background: #fff;
      border-radius: 15px;
      box-shadow: 0 0 20px rgba(124, 66, 157, 0.5);
      min-height: 100vh;
    }
  </style>
</head>
<body>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-3 sidebar text-dark">
      <h4 class="text-center mb-4">Commander</h4>
      <ul class="nav flex-column mb-auto" id="v-pills-tab" role="tablist">
        <li><a class="nav-link active" data-bs-toggle="pill" href="#leaders">Leaders</a></li>
        <li><a class="nav-link" data-bs-toggle="pill" href="#schedule">My Schedule</a></li>
        <li><a class="nav-link" href="request_changepass.php">Request Password Change</a></li>
        <li><a class="nav-link" href="activate.php">Activate Accounts</a></li>
      </ul>
      <div class="text-center mt-4">
        <a href="index.html" class="text-danger fw-bold">Sign Out</a>
      </div>
    </div>

    <div class="col-md-9 content-area">
      <div class="tab-content">
        <div class="tab-pane fade show active" id="leaders">
          <h4>All Leaders</h4>
          <table class="table table-bordered">
            <thead><tr><th>Name</th><th>Account Type</th><th>Actions</th></tr></thead>
            <tbody>
              <?php while ($row = $leaders->fetch_assoc()): ?>
                <tr>
                  <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                  <td><?= ucfirst($row['type_of_account']) ?></td>
                  <td>
  <?php
    $role = strtolower($row['type_of_account']); // assuming this is the column name
    $link = "#";
    if ($role === 'cubs') {
        $link = 'leader-cubs.php';
    } elseif ($role === 'junior') {
        $link = 'leader-junior.php';
    } elseif ($role === 'youth') {
        $link = 'leader-youth.php';
    }
  ?>
  <a href="<?= $link ?>" class="btn btn-sm btn-primary">View</a>
</td>

                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>

        <div class="tab-pane fade" id="schedule">
          <h4>My Schedule</h4>
          <table class="table table-bordered">
            <thead><tr><th>Date</th><th>Note</th></tr></thead>
            <tbody>
              <?php while ($row = $schedule->fetch_assoc()): ?>
                <tr>
                  <td><?= htmlspecialchars($row['schedule_date']) ?></td>
                  <td><?= htmlspecialchars($row['note']) ?></td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
