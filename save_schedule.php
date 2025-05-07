<?php
$conn = new mysqli("localhost", "root", "", "scout");
if ($conn->connect_error) {
    die("Connection failed");
}

$title = $_POST['title'];
$start = $_POST['start'];

$stmt = $conn->prepare("INSERT INTO schedule (title, start) VALUES (?, ?)");
$stmt->bind_param("ss", $title, $start);
$stmt->execute();
echo "Added";
