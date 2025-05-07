<?php
$success = false;

$conn = new mysqli("localhost", "root", "", "scout");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userInput = trim($_POST['userInput']);
    $tables = ['individual', 'admins'];

    foreach ($tables as $table) {
        $stmt = $conn->prepare("SELECT * FROM $table WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $userInput, $userInput);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $username = $row['username'];
            $email = $row['email'];
            $password = $row['password'];
            $full_info = json_encode($row); // save all details

            $insert = $conn->prepare("INSERT INTO requesttochangepass (source_table, username, email, password, full_info) VALUES (?, ?, ?, ?, ?)");
            $insert->bind_param("sssss", $table, $username, $email, $password, $full_info);
            $insert->execute();

            $success = true;
            break;
        }

        $stmt->close();
    }

    if (!$success) {
        $success = true; // show success message anyway
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot Password - Lebanon Scout</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">
  <style>
    body {
      background: url('assets/img/hero-bg-2.jpg') no-repeat center center fixed;
      background-size: cover;
      font-family: 'Poppins', sans-serif;
    }
    .forgot-box {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      padding: 40px;
      max-width: 400px;
      margin: 100px auto;
      box-shadow: 0 0 20px rgba(124, 66, 157, 0.5);
    }
    .forgot-title {
      font-weight: bold;
      color: #5a189a;
    }
    .btn-purple {
      background-color: #7209b7;
      border-color: #7209b7;
      color: white;
    }
    .btn-purple:hover {
      background-color: #560bad;
      border-color: #560bad;
    }
  </style>
</head>
<body>

<div class="forgot-box">
  <h2 class="text-center mb-4 forgot-title">Forgot Password</h2>
  <p class="text-center text-muted mb-4">Enter your email or username and we’ll contact you to reset your password.</p>

  <?php if ($success): ?>
    <div class="alert alert-success text-center">
      If this account exists, we’ll be in touch soon!
    </div>
  <?php else: ?>
    <form method="POST">
      <div class="mb-3">
        <label for="userInput" class="form-label">Email or Username:</label>
        <input type="text" name="userInput" id="userInput" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-purple w-100">Send Request</button>
    </form>
  <?php endif; ?>
</div>

</body>
</html>
