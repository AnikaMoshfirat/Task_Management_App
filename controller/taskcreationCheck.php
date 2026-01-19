<?php
session_start();
require_once('../../model/db.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conn = getConnection();
    if (!$conn) {
        die("Database connection failed!");
    }
    $userId = $_SESSION['user_id'] ?? null;
    if (!$userId) {
        echo "<script>alert('User not logged in.'); window.location.href='../view/php/taskcreation.php';</script>";
        exit;
    }

    $taskName = mysqli_real_escape_string($conn, $_POST['taskName']);
    $taskDesc = mysqli_real_escape_string($conn, $_POST['taskDesc']);
    $taskLabel = mysqli_real_escape_string($conn, $_POST['taskLabel']);
    $taskCategory = mysqli_real_escape_string($conn, $_POST['taskCategory']);
    $startTime = mysqli_real_escape_string($conn, $_POST['startTime']);
    $endTime = mysqli_real_escape_string($conn, $_POST['endTime']);
    $taskFile = $_FILES['detailedTaskFile'];

    $errors = [];
    if (preg_match('/\d/', $taskName)) {
        $errors[] = "Error: Task name cannot contain numbers.";
    }
    if (empty($taskDesc)) {
        $errors[] = "Error: Task description cannot be empty.";
    }
    if (empty($taskCategory)) {
        $errors[] = "Error: Please select a task category.";
    }
    if (empty($startTime)) {
        $errors[] = "Error: Start time cannot be empty.";
    }
    if (empty($endTime)) {
        $errors[] = "Error: End time cannot be empty.";
    }
    if ($taskFile['error'] == UPLOAD_ERR_NO_FILE) {
        $errors[] = "Error: Please upload a file.";
    }

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
        exit;
    }

    $targetDir = "../asset/upload/taskFiles/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $fileName = time() . "_" . basename($taskFile["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
    $allowed = ["pdf", "docx", "txt"];

    if (!in_array($fileType, $allowed)) {
        echo "<script>alert('Invalid file type. Only PDF, DOCX & TXT allowed!');</script>";
        exit;
    }

    if (!move_uploaded_file($taskFile["tmp_name"], $targetFilePath)) {
        echo "<script>alert('File upload failed.');</script>";
        exit;
    }

    $sql = "INSERT INTO taskinfos (ID, taskName, taskDesc, taskLabel, taskCategory, startTime, endTime, taskFile)
            VALUES ('$userId', '$taskName', '$taskDesc', '$taskLabel', '$taskCategory', '$startTime', '$endTime', '$targetFilePath')";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] = "Task added successfully.";
        header("Location: ../view/php/taskcreation.php");
        exit;
    } else {
        echo "Database error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
