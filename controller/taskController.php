<?php
session_start();

if(empty($_SESSION['userID'])) {
    http_response_code(401); 
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

require_once('../model/taskModel.php');

$userID = $_SESSION['userID'];

if($_SERVER['REQUEST_METHOD'] === 'GET') {
    $tasks = getAllTasks($userID);
    header('Content-Type: application/json'); 
    echo json_encode($tasks);
    exit;
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['taskID'], $input['isDone'])) {
        http_response_code(400); 
        echo json_encode(['success' => false, 'message' => 'Invalid input']);
        exit;
    }

    $success = updateTaskStatus($input['taskID'], $input['isDone'], $userID);
    header('Content-Type: application/json'); 
    echo json_encode(['success' => $success]);
    exit;
}
?>