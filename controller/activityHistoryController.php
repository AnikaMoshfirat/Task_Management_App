<?php
session_start(); 

header("Content-Type: application/json");
require_once('../model/db.php');

$conn = getConnection();

if (!$conn) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed"]);
    exit();
}

if(empty($_SESSION['userID'])) {
    http_response_code(401); 
    echo json_encode(["error" => "Unauthorized. Please log in to view tasks."]);
    exit();
}

$userID = $_SESSION['userID'];
$sql = "SELECT taskName, taskCategory, startTime, endTime,isDone FROM taskinfos WHERE ID = ?";
$stmt = mysqli_prepare($conn, $sql);

$tasks = [];

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $userID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $tasks[] = $row;
        }
    }
    mysqli_stmt_close($stmt);
} else {
    http_response_code(500);
    echo json_encode(["error" => "Failed to prepare SQL statement."]);
    $conn->close();
    exit();
}

echo json_encode($tasks);
$conn->close();
?>