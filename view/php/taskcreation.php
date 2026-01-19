<?php
session_start();
require_once('../../model/db.php');

if (!isset($_SESSION['userID'])) {
    die("Unauthorized access. Please log in.");
}

$errors = [];
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conn = getConnection();
    if (!$conn) {
        die("Database connection failed!");
    }

    $taskName = trim(mysqli_real_escape_string($conn, $_POST['taskName'] ?? ''));
    $taskDesc = trim(mysqli_real_escape_string($conn, $_POST['taskDesc'] ?? ''));
    $taskLabel = trim(mysqli_real_escape_string($conn, $_POST['taskLabel'] ?? ''));
    $taskCategory = trim(mysqli_real_escape_string($conn, $_POST['taskCategory'] ?? ''));
    $startTime = trim(mysqli_real_escape_string($conn, $_POST['startTime'] ?? ''));
    $endTime = trim(mysqli_real_escape_string($conn, $_POST['endTime'] ?? ''));

    if (empty($taskName)) {
        $errors[] = "Task name is required.";
    } elseif (preg_match('/\d/', $taskName)) {
        $errors[] = "Task name cannot contain numbers.";
    }
    if (empty($taskDesc)) {
        $errors[] = "Task description cannot be empty.";
    }
    if (empty($taskCategory)) {
        $errors[] = "Please select a task category.";
    }
    if (empty($startTime)) {
        $errors[] = "Start time cannot be empty.";
    }
    if (empty($endTime)) {
        $errors[] = "End time cannot be empty.";
    }
    if (!isset($_FILES['detailedTaskFile']) || $_FILES['detailedTaskFile']['error'] === UPLOAD_ERR_NO_FILE) {
        $errors[] = "Please upload a file.";
    }

    if (empty($errors)) {
        $file = $_FILES['detailedTaskFile'];
        $allowedTypes = ['pdf', 'docx', 'txt'];
        $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($fileExt, $allowedTypes)) {
            $errors[] = "Invalid file type. Only PDF, DOCX, and TXT are allowed.";
        } elseif ($file['error'] !== UPLOAD_ERR_OK) {
            $errors[] = "File upload error. Please try again.";
        } else {
            $uploadDir = __DIR__ . "/../../asset/upload/taskFiles/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $newFileName = time() . "_" . basename($file['name']);
            $targetFilePath = $uploadDir . $newFileName;

            if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
                // Prepare relative file path to store in DB
                $relativeFilePath = "asset/upload/taskFiles/" . $newFileName;

                $userId = $_SESSION['userID'];
                $sql = "INSERT INTO taskinfos 
                        (ID, taskName, taskDesc, taskLabel, taskCategory, startTime, endTime, taskFile)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

                $stmt = $conn->prepare($sql);
                $stmt->bind_param(
                    "isssssss",
                    $userId,
                    $taskName,
                    $taskDesc,
                    $taskLabel,
                    $taskCategory,
                    $startTime,
                    $endTime,
                    $relativeFilePath
                );

                if ($stmt->execute()) {
                    $success = "Task added successfully.";
                    header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
                    exit;
                } else {
                    $errors[] = "Database error: " . $stmt->error;
                }
                $stmt->close();
            } else {
                $errors[] = "Failed to move uploaded file.";
            }
        }
    }
    $conn->close();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Create Task</title>
    <link rel="stylesheet" href="../../asset/css/taskcreation.css" />
    <link rel="icon" type="image/png" href="../../asset/imgs/icon.png" />
</head>
<body>
<div class="task-container">
    <header>
        <h1>Create a Task</h1>
    </header>

    <?php
    if (!empty($errors)) {
        echo '<div class="error-messages"><ul>';
        foreach ($errors as $error) {
            echo "<li>" . htmlspecialchars($error) . "</li>";
        }
        echo '</ul></div>';
    } elseif (isset($_GET['success'])) {
        echo '<div class="success-message">Task added successfully.</div>';
    }
    ?>

    <div class="quick-add">
        <input type="text" id="quickTaskInput" placeholder="Type task name..." />
        <button onclick="quickAddTask()">Quick Add</button>
        <button onclick="toggleAdvanced()">+</button>
        <button onclick="toggleCategoryManager()">Categories</button>
    </div>

    <div class="advanced-form" id="advancedForm" style="display:none;">
        <h2>Detailed Task Form</h2>
        <form id="taskForm" method="post" action="" enctype="multipart/form-data" novalidate>
            <input type="text" name="taskName" placeholder="Task Name" required />
            <textarea name="taskDesc" placeholder="Task Description" required></textarea>
            <input type="text" name="taskLabel" placeholder="Labels (comma separated)" />
            <select name="taskCategory" required>
                <option value="">Select Category</option>
                <option value="development">Development</option>
                <option value="design">Design</option>
                <option value="education">Education</option>
                <option value="research">Research</option>
                <option value="marketing">Marketing</option>
                <option value="others">Others</option>

            </select>
            <label for="startTime">Start Time:</label>
            <input type="datetime-local" name="startTime" required />
            <label for="endTime">End Time:</label>
            <input type="datetime-local" name="endTime" required />
            <label for="detailedTaskFile">Upload File:</label>
            <input type="file" name="detailedTaskFile" accept=".pdf,.docx,.txt" required />
            <button type="submit">Add Task</button>
        </form>
    </div>

    <div class="category-manager" id="categoryManager" style="display:none;">
        <h2>Category Manager</h2>
        <div class="quick-add">
            <input type="text" id="newCategoryInput" placeholder="New category name..." />
            <button onclick="addCategory()">Add</button>
        </div>
        <ul id="categoryList"></ul>
    </div>

    <div class="task-lists" id="taskLists"></div>

    <div id="toast" class="toast"></div>
</div>

<script src="../../asset/js/taskcreation.js"></script>
</body>
</html>
