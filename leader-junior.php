<?php
session_start();
$error = '';
$success = '';

$conn = new mysqli("localhost", "root", "", "scout");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'leader1';
$userId = $_SESSION['user_id'] ?? 0;

// Handle News Upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_news'])) {
    $news_title = $_POST['news_title'];
    $news_content = $_POST['news_content'];
    $news_image = '';
    if (isset($_FILES['news_image']) && $_FILES['news_image']['error'] == 0) {
        $upload_dir = 'uploads/news/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        $news_image = time() . '_' . basename($_FILES['news_image']['name']);
        move_uploaded_file($_FILES['news_image']['tmp_name'], $upload_dir . $news_image);
    }
    $stmt = $conn->prepare("INSERT INTO news2 (title, content, image, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sss", $news_title, $news_content, $news_image);
    $success = $stmt->execute() ? "News added successfully!" : "Error uploading news.";
}

// Handle Task Upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_task'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $deadline = $_POST['deadline'];
    $duration = $_POST['duration'];
    $video_link = $_POST['video_link'];
    $grade_over = $_POST['grade_over'];
    $image_name = '';
    if (isset($_FILES['task_image']) && $_FILES['task_image']['error'] == 0) {
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        $image_name = time() . '_' . basename($_FILES['task_image']['name']);
        move_uploaded_file($_FILES['task_image']['tmp_name'], $upload_dir . $image_name);
    }
    $stmt = $conn->prepare("INSERT INTO tasks2 (title, description, deadline, leader_id, target_group, image, video_link, duration_minutes, grade_over, created_at) VALUES (?, ?, ?, ?, 'cubs', ?, ?, ?, ?, NOW())");
    $stmt->bind_param("sssissii", $title, $description, $deadline, $userId, $image_name, $video_link, $duration, $grade_over);
    if ($stmt->execute()) {
        $task_id = $stmt->insert_id;
        $success = "Task added successfully!";
        $cubs = $conn->query("SELECT id FROM individual WHERE TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 10 AND 15");
        while ($cub = $cubs->fetch_assoc()) {
            $conn->query("INSERT INTO grades2 (task_id, individual_id, grade) VALUES ($task_id, {$cub['id']}, NULL)");
        }
    } else {
        $error = "Error adding task.";
    }
}

// Save Grades
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_grades']) && isset($_POST['grades2'])) {
  foreach ($_POST['grades2'] as $grade_id => $grade) {
      $grade = is_numeric($grade) ? $grade : "NULL";
      $conn->query("UPDATE grades2 SET grade = $grade WHERE id = $grade_id");
  }
  $success = "Grades updated successfully!";
}


// Save Schedule
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_schedule'])) {
    $date = $_POST['event_date'];
    $note = $_POST['note'];
    $stmt = $conn->prepare("INSERT INTO schedule2 (schedule_date, note) VALUES (?, ?)");
    $stmt->bind_param("ss", $date, $note);
    $stmt->execute();
    $stmt->close();
    $success = "Schedule task added!";
}
// Handle Attendance Submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_attendance'])) {
  $attend_date = $_POST['attend_date'];
  $attendance2 = $_POST['attendance2'] ?? [];

  // Delete old records for same date to prevent duplicates
  $conn->query("DELETE FROM attendance2 WHERE attend_date = '$attend_date'");

  foreach ($attendance2 as $id => $status) {
      $stmt = $conn->prepare("INSERT INTO attendance2 (individual_id, attend_date, status) VALUES (?, ?, ?)");
      $stmt->bind_param("iss", $id, $attend_date, $status);
      $stmt->execute();
      $stmt->close();
  }

  $success = "Attendance saved for $attend_date.";
}

// Fetch Tasks and Grades
$tasks2 = $conn->query("SELECT id, title FROM tasks2 WHERE target_group = 'cubs'");
$cubs = $conn->query("SELECT id, CONCAT(first_name, ' ', last_name) AS name FROM individual WHERE TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 10 AND 15");

$grades_data = [];
$task_list = [];

if ($tasks2 && $cubs) {
    while ($task = $tasks2->fetch_assoc()) {
      $task_list[$task['id']] = $task['title'];

    }
    $cubs->data_seek(0);
    while ($cub = $cubs->fetch_assoc()) {
        $grades_data[$cub['id']] = ['name' => $cub['name'], 'grades' => []];
        foreach ($task_list as $task_id => $task_title) {
            $grade_q = $conn->query("SELECT id, grade FROM grades2 WHERE task_id = $task_id AND individual_id = {$cub['id']}");

            $grade_row = $grade_q->fetch_assoc();
            $grades_data[$cub['id']]['grades'][$task_id] = $grade_row ?? ['id' => 0, 'grade' => null];
        }
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_task'])) {
  $task_id = $_POST['task_id'];
  $title = $_POST['title'];
  $description = $_POST['description'];
  $deadline = $_POST['deadline'];
  $video_link = $_POST['video_link'];
  $duration = $_POST['duration'];
  $grade_over = $_POST['grade_over'];

  $stmt = $conn->prepare("UPDATE tasks2 SET title=?, description=?, deadline=?, video_link=?, duration_minutes=?, grade_over=? WHERE id=?");
  $stmt->bind_param("ssssiii", $title, $description, $deadline, $video_link, $duration, $grade_over, $task_id);
  $success = $stmt->execute() ? "Task updated successfully!" : "Failed to update task.";
  $stmt->close();
}

// Fetch tasks for editing
$edit_tasks = $conn->query("SELECT * FROM tasks2 WHERE target_group = 'cubs' ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Leader Cubs Dashboard - Lebanon Scout</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />

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
    .nav-link {
      color:rgb(90, 24, 154);
    }
    .nav-link.active {
      background-color: #fff;
      font-weight: bold;
      border-radius: 8px;
    }
    .content-area {
      padding: 30px;
      background: #fff;
      border-radius: 15px;
      box-shadow: 0 0 20px rgba(124, 66, 157, 0.5);
      min-height: 100vh;
    }
    #calendar {
      background-color: white;
      padding: 20px;
      border-radius: 15px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      min-height: 500px;
    }
  </style>
</head>
<body>
<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-3 sidebar text-dark">
      <h4 class="text-center mb-4">Cubs Leader</h4>
      <ul class="nav flex-column mb-auto" id="v-pills-tab" role="tablist">
        <li><a class="nav-link active" data-bs-toggle="pill" href="#news">Upload News</a></li>
        <li><a class="nav-link" data-bs-toggle="pill" href="#tasks">Create Task</a></li>
           <li><a class="nav-link" data-bs-toggle="pill" href="#edit_tasks">Edit Tasks</a></li>
        <li><a class="nav-link" data-bs-toggle="pill" href="#grades">Grades</a></li>
        <li><a class="nav-link" data-bs-toggle="pill" href="#attendance">Attendance</a></li>
        <li><a class="nav-link" data-bs-toggle="pill" href="#schedule">Schedule</a></li>
      </ul>
      <div class="text-center mt-4">
        <a href="index.html" class="text-danger fw-bold">Sign Out</a>
      </div>
    </div>

    <!-- Main Content -->
    <div class="col-md-9 content-area">
      <?php if (!empty($success)): ?>
        <div class="alert alert-success text-center"><?php echo $success; ?></div>
      <?php endif; ?>
      <?php if (!empty($error)): ?>
        <div class="alert alert-danger text-center"><?php echo $error; ?></div>
      <?php endif; ?>

      <div class="tab-content">
        <div class="tab-pane fade show active" id="news">
          <h4>Upload News</h4>
          <form method="POST" enctype="multipart/form-data">
            <input type="text" name="news_title" class="form-control mb-3" placeholder="Title" required>
            <textarea name="news_content" class="form-control mb-3" rows="5" placeholder="Content" required></textarea>
            <input type="file" name="news_image" class="form-control mb-3">
            <button type="submit" name="create_news" class="btn btn-warning">Publish</button>
          </form>
        </div>

        <div class="tab-pane fade" id="tasks">
          <h4>Create Task</h4>
          <form method="POST" enctype="multipart/form-data">
            <input type="text" name="title" class="form-control mb-3" placeholder="Task Title" required>
            <textarea name="description" class="form-control mb-3" rows="4" placeholder="Description" required></textarea>
            <input type="date" name="deadline" class="form-control mb-3" required>
            <input type="file" name="task_image" class="form-control mb-3">
            <input type="url" name="video_link" class="form-control mb-3" placeholder="Video Link (optional)">
            <input type="number" name="duration" class="form-control mb-3" placeholder="Duration (minutes)">
            <input type="number" name="grade_over" class="form-control mb-3" placeholder="Grade Over" required>
            <button type="submit" name="create_task" class="btn btn-primary">Create Task</button>
          </form>
        </div>
        <div class="tab-pane fade" id="edit_tasks">
  <h4>Edit Tasks</h4>
  <?php if ($edit_tasks && $edit_tasks->num_rows > 0): ?>
    <?php while ($task = $edit_tasks->fetch_assoc()): ?>
      <form method="POST">
        <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
        <div class="mb-2">
          <input type="text" name="title" value="<?= htmlspecialchars($task['title']) ?>" class="form-control" placeholder="Title">
        </div>
        <div class="mb-2">
          <textarea name="description" class="form-control" placeholder="Description"><?= htmlspecialchars($task['description']) ?></textarea>
        </div>
        <div class="mb-2">
          <input type="date" name="deadline" value="<?= $task['deadline'] ?>" class="form-control">
        </div>
        <div class="mb-2">
          <input type="text" name="video_link" value="<?= $task['video_link'] ?>" class="form-control" placeholder="Video Link">
        </div>
        <div class="mb-2">
          <input type="number" name="duration" value="<?= $task['duration_minutes'] ?>" class="form-control" placeholder="Duration">
        </div>
        <div class="mb-2">
          <input type="number" name="grade_over" value="<?= $task['grade_over'] ?>" class="form-control" placeholder="Grade Over">
        </div>
        <button type="submit" name="update_task" class="btn btn-primary mb-3">Update Task</button>
      </form>
      <hr>
    <?php endwhile; ?>
  <?php else: ?>
    <p>No tasks available to edit.</p>
  <?php endif; ?>
</div>

<div class="tab-pane fade" id="grades">
          <h4>Assign Grades</h4>
          <form method="POST">
            <table class="table table-bordered">
              <thead><tr><th>Individual</th>
              <?php foreach ($task_list as $title) echo "<th>$title</th>"; ?>
              </tr></thead>
              <tbody>
              <?php foreach ($grades_data as $cub): ?>
                <tr><td><?php echo $cub['name']; ?></td>
                <?php foreach ($cub['grades'] as $grade): ?>
                  <td><input type="number" class="form-control" name="grades2[<?= $grade['id'] ?>]" value="<?= $grade['grade'] ?>"></td>
                <?php endforeach; ?>
                </tr>
              <?php endforeach; ?>
              </tbody>
            </table>
            <button type="submit" name="save_grades" class="btn btn-success">Save Grades</button>
          </form>
        </div>

        <div class="tab-pane fade" id="attendance">
          
  <h4 class="mb-3">Attendance</h4>
  <form method="POST">
    <div class="mb-3">
      <label for="attend_date">Date</label>
      <input type="date" name="attend_date" id="attend_date" class="form-control" required>
    </div>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Name</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $cubs = $conn->query("SELECT id, CONCAT(first_name, ' ', last_name) AS name FROM individual WHERE TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 10 AND 15");
        while ($cub = $cubs->fetch_assoc()):
        ?>
        <tr>
          <td><?= htmlspecialchars($cub['name']) ?></td>
          <td>
          <select name="attendance2[<?= $cub['id'] ?>]" class="form-control">

              <option value="present">Present</option>
              <option value="absent">Absent</option>
            </select>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
    <button type="submit" name="save_attendance" class="btn btn-success">Save Attendance</button>
  </form>
</div>


        <!-- SCHEDULE TAB -->
        <div class="tab-pane fade" id="schedule">
          <h4>Schedule Tasks</h4>
          <form method="POST" class="mb-4">
            <input type="date" name="event_date" class="form-control mb-2" required>
            <input type="text" name="note" class="form-control mb-2" placeholder="Task Note" required>
            <button type="submit" name="save_schedule" class="btn btn-primary">Add To Schedule</button>
          </form>
          <div id="calendar"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      events: [
        <?php
        $sched = $conn->query("SELECT schedule_date, note FROM schedule2");
        while ($e = $sched->fetch_assoc()) {
            echo "{ title: '" . addslashes($e['note']) . "', start: '" . $e['schedule_date'] . "' },";
        }
        ?>
      ]
    });
    calendar.render();
  });
</script>
</body>
</html>
