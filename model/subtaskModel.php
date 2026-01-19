<?php
require_once('db.php');

function getSubtasksByTaskID($taskID) {
    $conn = getConnection();
    $subtasks = [];
    if (!$conn) return $subtasks;
    $sql = "SELECT * FROM subtasks WHERE taskID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $taskID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $row['isDone'] = (int)$row['isDone'];
                $subtasks[] = $row;
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
    return $subtasks;
}

function addSubtask($taskID, $subtaskName, $subtaskDesc) {
    $conn = getConnection();
    if (!$conn) return false;
    $sql = "INSERT INTO subtasks (taskID, subtaskName, subtaskDesc) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "iss", $taskID, $subtaskName, $subtaskDesc);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } else {
        $result = false;
    }
    mysqli_close($conn);
    return $result;
}

function updateSubtask($subtaskID, $subtaskName, $subtaskDesc) {
    $conn = getConnection();
    if (!$conn) return false;
    $sql = "UPDATE subtasks SET subtaskName = ?, subtaskDesc = ? WHERE subtaskID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssi", $subtaskName, $subtaskDesc, $subtaskID);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } else {
        $result = false;
    }
    mysqli_close($conn);
    return $result;
}

function deleteSubtask($subtaskID) {
    $conn = getConnection();
    if (!$conn) return false;
    $sql = "DELETE FROM subtasks WHERE subtaskID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $subtaskID);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } else {
        $result = false;
    }
    mysqli_close($conn);
    return $result;
}

function setSubtaskDone($subtaskID, $isDone) {
    $conn = getConnection();
    if (!$conn) return false;
    $sql = "UPDATE subtasks SET isDone = ? WHERE subtaskID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ii", $isDone, $subtaskID);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } else {
        $result = false;
    }
    mysqli_close($conn);
    return $result;
}

?> 