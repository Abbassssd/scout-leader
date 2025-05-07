<?php
$conn = new mysqli("localhost", "root", "", "scout");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['activate_id'])) {
    $id = intval($_GET['activate_id']);
    $conn->query("UPDATE individual SET is_active = 'YES' WHERE id = $id");
}

$result = $conn->query("SELECT * FROM individual");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Activate Individual Accounts</title>
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <h2 class="mb-4 text-center text-primary">Activate Scout Accounts</h2>
  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Username</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= $row['first_name'] . " " . $row['last_name'] ?></td>
          <td><?= $row['email'] ?></td>
          <td><?= $row['username'] ?></td>
          <td><?= $row['is_active'] ?></td>
          <td>
            <?php if ($row['is_active'] == 'NO'): ?>
              <a href="activate.php?activate_id=<?= $row['id'] ?>" class="btn btn-success btn-sm">Activate</a>
            <?php else: ?>
              <span class="text-success fw-bold">Activated</span>
            <?php endif; ?>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

</body>
</html>
