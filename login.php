<?php
session_start();
$error = '';

// Connect to the database
$conn = new mysqli("localhost", "root", "", "scout");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST['role'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $redirectMap = [
        "leader1" => "leader-cubs.php",
        "leader2" => "dashboard2.php",
        "leader3" => "dashboard3.php",
        "leader4" => "commander.php",
        "individual1" => "cubs.php",
        "individual2" => "junior.php",
        "individual3" => "youth.php",
    ];

    if (strpos($role, 'leader') === 0) {
        $table = 'admins';
        $query = "SELECT id, password, is_active, type_of_account FROM $table WHERE username = ?";
    } else {
        $table = 'individual';
        $query = "SELECT id, password, is_active, date_of_birth FROM $table WHERE username = ?";
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if ($row['is_active'] === 'NO') {
            $error = "Your account is deactivated.";
        } elseif ($password === $row['password']) {
            if ($table === 'admins') {
                $roleTypeMap = [
                    "leader1" => "cubs",
                    "leader2" => "junior",
                    "leader3" => "youth",
                    "leader4" => "commander"
                ];
                if ($roleTypeMap[$role] !== strtolower($row['type_of_account'])) {
                    $error = "Access denied: You are not assigned as a " . ucfirst($roleTypeMap[$role]) . ".";
                }
            }

            if ($table === 'individual' && empty($error)) {
                $dob = new DateTime($row['date_of_birth']);
                $today = new DateTime();
                $age = $today->diff($dob)->y;

                $ageValid = false;
                if ($role === "individual1" && $age >= 5 && $age <= 9) $ageValid = true;
                if ($role === "individual2" && $age > 9 && $age <= 15) $ageValid = true;
                if ($role === "individual3" && $age > 15 && $age <= 19) $ageValid = true;

                if (!$ageValid) {
                    $error = "Your age does not match the selected group.";
                }
            }

            if (empty($error)) {
                $update = $conn->prepare("UPDATE $table SET last_login = NOW() WHERE id = ?");
                $update->bind_param("i", $row['id']);
                $update->execute();

                $_SESSION['role'] = $role;
                $_SESSION['user_id'] = $row['id'];

                if (isset($redirectMap[$role])) {
                    header("Location: " . $redirectMap[$role]);
                    exit();
                } else {
                    $error = "Invalid role selected.";
                }
            }
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "User not found.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - Lebanon Scout</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">
  <style>
    body {
      background: url('assets/img/hero-bg-2.jpg') no-repeat center center fixed;
      background-size: cover;
      font-family: 'Poppins', sans-serif;
    }

    .login-box {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      padding: 40px;
      max-width: 400px;
      margin: 100px auto;
      box-shadow: 0 0 20px rgba(124, 66, 157, 0.5);
    }

    .login-title {
      font-weight: bold;
      color: #5a189a;
    }

    .btn-primary {
      background-color: #7209b7;
      border-color: #7209b7;
    }

    .btn-primary:hover {
      background-color: #560bad;
      border-color: #560bad;
    }

    .forgot-password {
      display: block;
      text-align: center;
      font-size: 0.9em;
      color: #5a189a;
      margin-top: 15px;
    }
  </style>
</head>
<body>

<div class="login-box">
  <h2 class="text-center mb-4 login-title">Scout Login</h2>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger text-center"><?php echo $error; ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="mb-3">
      <label for="role" class="form-label">Login as:</label>
      <select name="role" id="role" class="form-control" required>
        <optgroup label="Leaders">
          <option value="leader1">Leader-Cubs</option>
          <option value="leader2">Leader-Juniors</option>
          <option value="leader3">Leader-Youth</option>
          <option value="leader4">Leader-Commander</option>
        </optgroup>
        <optgroup label="Individuals">
          <option value="individual1">Individual-Cub</option>
          <option value="individual2">Individual-Junior</option>
          <option value="individual3">Individual-Youth</option>
        </optgroup>
      </select>
    </div>

    <div class="mb-3">
      <label for="username" class="form-label">Username:</label>
      <input type="text" name="username" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">Password:</label>
      <input type="password" name="password" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary w-100">Sign In</button>
    <a href="forgot_password.php" class="forgot-password">Forgot Password?</a>
  </form>
</div>

<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>