<?php
require_once('../model/subtaskModel.php');
header('Content-Type: application/json');

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'get':
        $taskID = intval($_GET['taskID'] ?? 0);
        $subtasks = getSubtasksByTaskID($taskID);
        echo json_encode(['success' => true, 'subtasks' => $subtasks]);
        break;
    case 'add':
        $taskID = intval($_POST['taskID'] ?? 0);
        $name = trim($_POST['subtaskName'] ?? '');
        $desc = trim($_POST['subtaskDesc'] ?? '');
        $result = addSubtask($taskID, $name, $desc);
        echo json_encode(['success' => $result]);
        break;
    case 'update':
        $subtaskID = intval($_POST['subtaskID'] ?? 0);
        $name = trim($_POST['subtaskName'] ?? '');
        $desc = trim($_POST['subtaskDesc'] ?? '');
        $result = updateSubtask($subtaskID, $name, $desc);
        echo json_encode(['success' => $result]);
        break;
    case 'delete':
        $subtaskID = intval($_POST['subtaskID'] ?? 0);
        $result = deleteSubtask($subtaskID);
        echo json_encode(['success' => $result]);
        break;
    case 'setDone':
        $subtaskID = intval($_POST['subtaskID'] ?? 0);
        $isDone = intval($_POST['isDone'] ?? 0);
        $result = setSubtaskDone($subtaskID, $isDone);
        echo json_encode(['success' => $result]);
        break;
    default:
        echo json_encode(['success' => false, 'error' => 'Invalid action']);
        break;
} 