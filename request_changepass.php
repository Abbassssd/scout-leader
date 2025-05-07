<?php
$conn = new mysqli("localhost", "root", "", "scout");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM requesttochangepass ORDER BY request_time DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Password Change Requests</title>
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Poppins', sans-serif;
    }
    .container {
      margin-top: 50px;
    }
    .table-title {
      font-weight: bold;
      color: #5a189a;
      margin-bottom: 20px;
      text-align: center;
    }
  </style>
</head>
<body>

<div class="container">
  <h2 class="table-title">Password Change Requests</h2>
  <table class="table table-bordered table-striped">
    <thead class="table-light">
      <tr>
        <th>#</th>
        <th>Username</th>
        <th>Email</th>
        <th>From</th>
        <th>Password</th>
        <th>Request Time</th>
        <th>Full Info (JSON)</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result && $result->num_rows > 0): $i = 1; ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $i++ ?></td>
            <td><?= htmlspecialchars($row['username']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= ucfirst($row['source_table']) ?></td>
            <td><?= htmlspecialchars($row['password']) ?></td>
            <td><?= $row['request_time'] ?></td>
            <td><pre><?= htmlspecialchars($row['full_info']) ?></pre></td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="7" class="text-center">No requests found.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

</body>
</html>

<?php $conn->close(); ?>
