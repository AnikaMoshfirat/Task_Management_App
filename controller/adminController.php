<?php
session_start();
header('Content-Type: application/json');
if (empty($_SESSION['userID']) || (empty($_SESSION['role']) || $_SESSION['role'] !== 'Admin')) {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}
require_once('../model/userModel.php');
require_once('../model/taskModel.php');

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'getUsers':
        $users = getAllUsers();
        echo json_encode(['success' => true, 'users' => $users]);
        break;
    case 'changeRole':
        $userID = intval($_POST['userID'] ?? 0);
        $newRole = $_POST['newRole'] ?? '';
        $result = updateUserRole($userID, $newRole);
        echo json_encode(['success' => $result]);
        break;
    case 'deleteUser':
        $userID = intval($_POST['userID'] ?? 0);
        $result = deleteUser($userID);
        echo json_encode(['success' => $result]);
        break;
    case 'getTasks':
        $tasks = getAllTasksForAdmin();
        echo json_encode(['success' => true, 'tasks' => $tasks]);
        break;
    case 'deleteTask':
        $taskID = intval($_POST['taskID'] ?? 0);
        $result = deleteTask($taskID);
        echo json_encode(['success' => $result]);
        break;
    case 'getLogs':
        $logs = getActivityLogs();
        echo json_encode(['success' => true, 'logs' => $logs]);
        break;
    default:
        echo json_encode(['success' => false, 'error' => 'Invalid action']);
        break;
} 