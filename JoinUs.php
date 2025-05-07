<?php
$success = false;
$error = '';

// Connect to the database
$conn = new mysqli("localhost", "root", "", "scout");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username     = $_POST['username'];
    $password     = $_POST['password'];
    $email        = $_POST['email'];
    $first_name   = $_POST['first_name'];
    $father_name  = $_POST['father_name'];
    $last_name    = $_POST['last_name'];
    $date_of_birth = $_POST['date_of_birth'];

    // Check if username OR email exists
    $checkExisting = $conn->prepare("SELECT id FROM individual WHERE username = ? OR email = ?");
    $checkExisting->bind_param("ss", $username, $email);
    $checkExisting->execute();
    $checkExisting->store_result();

    if ($checkExisting->num_rows > 0) {
        $error = "You are already registered. Please use another username or email.";
    } else {
        if (!preg_match("/^(?=.*[A-Z])(?=.*\W).{8,}$/", $password)) {
            $error = "Password must be at least 8 characters, contain one capital letter and one symbol.";
        } else {
            $stmt = $conn->prepare("INSERT INTO individual (
                first_name, father_name, last_name, mother_name, mother_family_name,
                email, your_number, mother_number, country, city, nationality,
                date_of_birth, civil_number, id_image, username, password, is_active
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'NO')");

            $stmt->bind_param(
                "ssssssssssssssss",
                $first_name, $father_name, $last_name, $_POST['mother_name'], $_POST['mother_family_name'],
                $email, $_POST['your_number'], $_POST['mother_number'], $_POST['country'], $_POST['city'], $_POST['nationality'],
                $date_of_birth, $_POST['civil_number'], $_POST['id_image'], $username, $password
            );

            if ($stmt->execute()) {
                $success = true;
            }

            $stmt->close();
        }
    }

    $checkExisting->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Join Us - Lebanon Scout</title>
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">
  <style>
    body {
      background: url('assets/img/hero-bg-2.jpg') no-repeat center center fixed;
      background-size: cover;
      font-family: 'Poppins', sans-serif;
    }

    .register-box {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      padding: 40px;
      max-width: 700px;
      margin: 60px auto;
      box-shadow: 0 0 20px rgba(124, 66, 157, 0.5);
    }

    .title {
      color: #5a189a;
      font-weight: bold;
    }

    .btn-purple {
      background-color: #7209b7;
      color: white;
      border-color: #7209b7;
    }

    .btn-purple:hover {
      background-color: #560bad;
      border-color: #560bad;
      color: white;
    }
  </style>
</head>
<body>

<div class="register-box">
  <h2 class="text-center title mb-4">Join the Scouts</h2>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger text-center"><?= $error ?></div>
  <?php endif; ?>

  <?php if ($success): ?>
    <div class="alert alert-success text-center">
      We’ll be back to you. Keep checking your email.
    </div>
  <?php else: ?>
    <form method="POST">
      <div class="row">
        <div class="col-md-6 mb-3"><input type="text" name="first_name" class="form-control" placeholder="First Name" required></div>
        <div class="col-md-6 mb-3"><input type="text" name="father_name" class="form-control" placeholder="Father Name" required></div>
        <div class="col-md-6 mb-3"><input type="text" name="last_name" class="form-control" placeholder="Last Name" required></div>
        <div class="col-md-6 mb-3"><input type="text" name="mother_name" class="form-control" placeholder="Mother Name" required></div>
        <div class="col-md-6 mb-3"><input type="text" name="mother_family_name" class="form-control" placeholder="Mother Family Name" required></div>
        <div class="col-md-6 mb-3"><input type="email" name="email" class="form-control" placeholder="Email" required></div>
        <div class="col-md-6 mb-3"><input type="text" name="your_number" class="form-control" placeholder="Your Number" required></div>
        <div class="col-md-6 mb-3"><input type="text" name="mother_number" class="form-control" placeholder="Mother Number" required></div>

        <div class="col-md-6 mb-3">
          <select name="country" class="form-control" required>
            <option value="" disabled selected>Select Country</option>
            <option value="Lebanon">Lebanon</option>
            <option value="Syria">Syria</option>
            <option value="Jordan">Jordan</option>
            <option value="Palestine">Palestine</option>
            <option value="Iraq">Iraq</option>
            <option value="Egypt">Egypt</option>
            <option value="Other">Other</option>
          </select>
        </div>

        <div class="col-md-6 mb-3"><input type="text" name="city" class="form-control" placeholder="City" required></div>

        <div class="col-md-6 mb-3">
          <select name="nationality" class="form-control" required>
            <option value="" disabled selected>Select Nationality</option>
            <option value="Lebanese">Lebanese</option>
            <option value="Syrian">Syrian</option>
            <option value="Jordanian">Jordanian</option>
            <option value="Palestinian">Palestinian</option>
            <option value="Iraqi">Iraqi</option>
            <option value="Egyptian">Egyptian</option>
            <option value="Other">Other</option>
          </select>
        </div>

        <div class="col-md-6 mb-3"><input type="date" name="date_of_birth" class="form-control" required></div>
        <div class="col-md-6 mb-3"><input type="text" name="civil_number" class="form-control" placeholder="Civil Number" required></div>
        <div class="col-md-6 mb-3"><input type="text" name="id_image" class="form-control" placeholder="ID Image Filename" required></div>
        <div class="col-md-6 mb-3"><input type="text" name="username" class="form-control" placeholder="Username" required></div>
        <div class="col-md-6 mb-3"><input type="password" name="password" class="form-control" placeholder="Password" required></div>
      </div>
      <button type="submit" class="btn btn-purple w-100">Register</button>
    </form>
  <?php endif; ?>
</div>

</body>
</html>
