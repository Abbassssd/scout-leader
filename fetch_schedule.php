<?php
$conn = new mysqli("localhost", "root", "", "scout");
if ($conn->connect_error) {
    die("Connection failed");
}

$result = $conn->query("SELECT * FROM schedule");
$events = [];
while ($row = $result->fetch_assoc()) {
    $events[] = [
        'title' => $row['title'],
        'start' => $row['start']
    ];
}
echo json_encode($events);
