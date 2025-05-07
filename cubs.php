<?php
session_start();

$conn = new mysqli("localhost", "root", "", "scout");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if individual is logged in
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['individual1', 'individual2', 'individual3'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Fetch individual profile info
$stmt = $conn->prepare("SELECT first_name, last_name, username, email, date_of_birth FROM individual WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$profile = $result->fetch_assoc();
$stmt->close();

// Calculate age
$dob = new DateTime($profile['date_of_birth']);
$today = new DateTime();
$age = $today->diff($dob)->y;

if ($age < 5 || $age > 9) {
    echo "Access Denied. Only cubs (5-9 years old) can access this page.";
    exit();
}

// Fetch tasks assigned for cubs
$tasks = [];
$task_query = $conn->query("SELECT * FROM tasks WHERE target_group = 'cubs' ORDER BY created_at DESC");
while ($row = $task_query->fetch_assoc()) {
    $tasks[] = $row;
}

// Fetch news
$news_list = [];
$news_query = $conn->query("SELECT * FROM news ORDER BY created_at DESC");
while ($row = $news_query->fetch_assoc()) {
    $news_list[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Cubs Dashboard - Lebanon Scout</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: url('assets/img/hero-bg-2.jpg') no-repeat center center fixed;
      background-size: cover;
    }
    .sidebar { background: #fff; padding: 20px; border-radius: 15px; height: 100vh; box-shadow: 0 0 15px rgba(0,0,0,0.1); display: flex; flex-direction: column; justify-content: space-between; }
    .profile-small { text-align: center; margin-bottom: 30px; }
    .profile-small img { width: 70px; height: 70px; border-radius: 50%; object-fit: cover; }
    .nav-link { color: #5a189a; }
    .nav-link.active { background-color: #ffe627; color: #000; font-weight: bold; }
    .content-area { padding: 30px; background: #fff; border-radius: 15px; box-shadow: 0 0 20px rgba(124, 66, 157, 0.5); }
    .logout-btn { margin-top: auto; text-align: center; }
    .task-card, .news-card { background: #f8f9fa; padding: 20px; border-radius: 15px; margin-bottom: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    .news-card img { width: 100%; height: 250px; object-fit: cover; border-radius: 10px; margin-bottom: 10px; }
  </style>
</head>
<body>
<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-3 sidebar d-flex flex-column">
      <div class="profile-small">
        <img src="assets/img/profile.png" alt="Profile">
        <h5 class="mt-2"><?php echo htmlspecialchars($profile['first_name']); ?></h5>
      </div>
      <ul class="nav nav-pills flex-column mb-auto" id="v-pills-tab" role="tablist">
        <li class="nav-item"><a class="nav-link active" id="v-pills-news-tab" data-bs-toggle="pill" href="#news">News</a></li>
        <li class="nav-item"><a class="nav-link" id="v-pills-tasks-tab" data-bs-toggle="pill" href="#tasks">Tasks</a></li>
        <li class="nav-item"><a class="nav-link" id="v-pills-grades-tab" data-bs-toggle="pill" href="#grades">Grades</a></li>
        <li class="nav-item"><a class="nav-link" id="v-pills-attendance-tab" data-bs-toggle="pill" href="#attendance">Attendance</a></li>
        <li class="nav-item"><a class="nav-link" id="v-pills-badges-tab" data-bs-toggle="pill" href="#badges">Badges</a></li>
        <li class="nav-item"><a class="nav-link" id="v-pills-progress-tab" data-bs-toggle="pill" href="#progress">Progress</a></li>
        <li class="nav-item"><a class="nav-link" id="v-pills-fun-tab" data-bs-toggle="pill" href="#fun">Fun Corner</a></li>
        <li class="nav-item"><a class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" href="#profile">Profile</a></li>
      </ul>
      <div class="logout-btn">
        <a href="logout.php" class="btn btn-danger">Sign Out</a>
      </div>
    </div>

    <!-- Content Area -->
    <div class="col-md-9">
      <div class="tab-content content-area" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="news" role="tabpanel">
          <h4 class="mb-4">Latest News</h4>
          <?php if (!empty($news_list)): foreach ($news_list as $news): ?>
            <div class="news-card">
              <img src="uploads/news/<?php echo htmlspecialchars($news['image']); ?>" alt="News Image">
              <h5><?php echo htmlspecialchars($news['title']); ?></h5>
              <p><?php echo nl2br(htmlspecialchars($news['content'])); ?></p>
              <small class="text-muted">Published on: <?php echo date('F j, Y', strtotime($news['created_at'])); ?></small>
            </div>
          <?php endforeach; else: ?>
            <p>No news posted yet.</p>
          <?php endif; ?>
        </div>
        <div class="tab-pane fade" id="tasks" role="tabpanel">
  <h4>Your Tasks</h4>
  <?php if (!empty($tasks)): ?>
  <?php foreach ($tasks as $task): ?>
    <div class="task-card mb-4 p-3 border rounded shadow-sm">
      <h5><?php echo htmlspecialchars($task['title']); ?></h5>
      <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($task['description'])); ?></p>
      <p><strong>Deadline:</strong> <?php echo date('F j, Y', strtotime($task['deadline'])); ?></p>
      <p><strong>Video Link:</strong>
        <?php if (!empty($task['video_link'])): ?>
          <a href="<?php echo htmlspecialchars($task['video_link']); ?>" target="_blank">Watch Video</a>
        <?php else: ?>
          None
        <?php endif; ?>
      </p>
      <p><strong>Duration:</strong> <?php echo $task['duration_minutes']; ?> minutes</p>
      <p><strong>Grade Over:</strong> <?php echo $task['grade_over']; ?></p>
      <p><strong>Created At:</strong> <?php echo $task['created_at']; ?></p>
      <?php if (!empty($task['image'])): ?>
        <p><strong>Image:</strong><br>
          <img src="uploads/<?php echo $task['image']; ?>" width="200" class="img-thumbnail">
        </p>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <p>No tasks assigned yet.</p>
<?php endif; ?>

</div>
        <div class="tab-pane fade" id="grades" role="tabpanel">
          <h4>Your Grades</h4>
          <table class="table table-bordered">
            <thead><tr><th>Task</th><th>Your Grade</th></tr></thead>
            <tbody>
              <?php
              $grades = $conn->query("SELECT t.title, g.grade, t.grade_over FROM grades g JOIN tasks t ON g.task_id = t.id WHERE g.individual_id = $userId");
              if ($grades->num_rows > 0):
                while ($row = $grades->fetch_assoc()): ?>
                <tr>
                  <td><?php echo htmlspecialchars($row['title']); ?></td>
                  <td><?php echo is_null($row['grade']) ? 'Pending' : $row['grade'] . ' / ' . $row['grade_over']; ?></td>
                </tr>
              <?php endwhile; else: ?>
                <tr><td colspan="2">No grades available yet.</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <div class="tab-pane fade" id="attendance" role="tabpanel">
  <h4 class="mb-4">Your Attendance</h4>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Date</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $attendance = $conn->query("SELECT attend_date, status FROM attendance WHERE individual_id = $userId ORDER BY attend_date DESC");
      if ($attendance->num_rows > 0):
        while ($row = $attendance->fetch_assoc()): ?>
          <tr>
            <td><?php echo date('F j, Y', strtotime($row['attend_date'])); ?></td>
            <td><?php echo ucfirst($row['status']); ?></td>
          </tr>
        <?php endwhile;
      else: ?>
        <tr><td colspan="2">No attendance records yet.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

        <div class="tab-pane fade" id="badges" role="tabpanel"><h4>Badges</h4><p>No badges earned yet. Keep working! 🏅</p></div>
        <div class="tab-pane fade" id="progress" role="tabpanel"><h4>Progress</h4><p>Progress tracking coming soon! 📊</p></div>
        <div class="tab-pane fade" id="fun" role="tabpanel">
  <h4 class="mb-4 text-center">🎮 Fun Corner - Play and Enjoy! 🎉</h4>
  <div class="row">

    <?php
    $games = [
      ['Coloring Game 🎨', 'https://www.crazygames.com/game/kid-doodle-coloring'],
      ['Memory Match 🧠', 'https://www.crazygames.com/game/memory-matching'],
      ['Balloon Pop 🎈', 'https://www.crazygames.com/game/balloon-pop'],
      ['Guess the Animal 🐾', 'https://www.crazygames.com/game/animal-quiz'],
      ['Bubble Shooter 🔵', 'https://www.crazygames.com/game/bubble-shooter'],
      ['Animal Puzzle 🧩', 'https://www.crazygames.com/game/jigsaw-puzzle'],
      ['Math Game ➕➖', 'https://www.crazygames.com/game/math-mahjong-relax'],
      ['Maze Challenge 🔍', 'https://www.crazygames.com/game/amazing-maze'],
      ['Dress Up Game 👗', 'https://www.crazygames.com/game/kids-fashion'],
      ['Jumping Adventure 🦘', 'https://www.crazygames.com/game/little-runner']
    ];

    foreach ($games as $game): ?>
      <div class="col-md-6 mb-4">
        <div class="card shadow text-center p-3">
          <h5><?php echo $game[0]; ?></h5>
          <button onclick="window.open('<?php echo $game[1]; ?>', '_blank')" class="btn btn-warning mt-3">Play</button>
        </div>
      </div>
    <?php endforeach; ?>

  </div>
</div>

        <div class="tab-pane fade" id="profile" role="tabpanel">
          <h4>Your Profile</h4>
          <p><strong>Username:</strong> <?php echo htmlspecialchars($profile['username']); ?></p>
          <p><strong>Email:</strong> <?php echo htmlspecialchars($profile['email']); ?></p>
          <p><strong>Age:</strong> <?php echo $age; ?> years old</p>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>