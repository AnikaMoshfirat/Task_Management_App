<?php
session_start();
header("Content-Type: application/json");
require_once('../model/db.php');

$conn = getConnection();

if (!isset($_SESSION['userID'])) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized: User not logged in."]);
    exit();
}

$userID = $_SESSION['userID']; 
$monday = $_POST['monday'] ?? null;

if (!$monday) {
    echo json_encode([]);
    exit();
}

$endDate = date('Y-m-d', strtotime($monday . ' +6 days'));

$sql = "SELECT taskName, taskCategory, startTime, isDone 
        FROM taskinfos 
        WHERE ID = ? AND startTime BETWEEN ? AND ? 
        ORDER BY startTime ASC";

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    http_response_code(500);
    echo json_encode(["error" => "Failed to prepare statement: " . mysqli_error($conn)]);
    exit();
}

$startDateTime = $monday . " 00:00:00";
$endDateTime = $endDate . " 23:59:59";

mysqli_stmt_bind_param($stmt, "iss", $userID, $startDateTime, $endDateTime);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$tasks = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $tasks[] = $row;
    }
}

echo json_encode($tasks);

mysqli_stmt_close($stmt);
mysqli_close($conn);