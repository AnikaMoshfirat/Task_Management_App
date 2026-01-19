<?php
session_start();
if (empty($_SESSION['userID']) || (empty($_SESSION['role']) || $_SESSION['role'] !== 'Admin')) {
    header('Location: ../../index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Admin Dashboard | TM</title>
    <link rel="stylesheet" href="../../asset/css/adminMenuStyle.css" />
    <link rel="icon" type="image/png" href="../../asset/imgs/icon.png" />
    <style>
        .admin-section { margin-bottom: 40px; background: #fff; border-radius: 8px; padding: 20px; box-shadow: 0 2px 8px #eee; }
        .admin-section h2 { margin-top: 0; }
        .admin-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .admin-table th, .admin-table td { border: 1px solid #ddd; padding: 8px; }
        .admin-table th { background: #f5f5f5; }
        .admin-action-btn { margin-right: 5px; }
    </style>
</head>
<body>
    <div class="admin-container">
        <header>
            <h1>Admin Dashboard</h1>
        </header>
        <div class="admin-section" id="userManagement">
            <h2>User Management</h2>
            <div id="userList"></div>
        </div>
        <div class="admin-section" id="taskManagement">
            <h2>Task Management</h2>
            <div id="taskList"></div>
        </div>
        <div class="admin-section" id="activityLogs">
            <h2>Activity Logs</h2>
            <div id="activityLogList"></div>
        </div>
    </div>
    <script src="../../asset/js/adminPanel.js"></script>
</body>
</html> 