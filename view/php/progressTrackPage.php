<?php
session_start();
if (empty($_SESSION['userID'])) {
    header('Location: ../../index.php');
    exit;
}

require_once('../../model/taskModel.php');

$userId = $_SESSION['userID'];
$tasks = getAllTasks($userId);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Task Progress Tracking</title>
    <link rel="stylesheet" href="../../asset/css/progressTrackStyle.css" />
    <link rel="icon" href="../../asset/imgs/icon.png" type="image/png" />
</head>
<body>

<div class="container">
    <h2>Task Progress Tracker</h2>

    <form id="taskForm">
        <table>
            <thead>
                <tr>
                    <th>Done</th>
                    <th>Task Name</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($tasks)): ?>
                    <?php foreach ($tasks as $task): ?>
                        <tr>
                            <td>
                                <input
                                    type="checkbox"
                                    class="task-checkbox"
                                    data-taskid="<?= htmlspecialchars($task['taskID']) ?>"
                                    <?= isset($task['isDone']) && $task['isDone'] ? 'checked' : '' ?>
                                />
                            </td>
                            <td><?= htmlspecialchars($task['taskName']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2">No tasks found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </form>

    <div id="progressDashboard" style="margin-top: 20px;">
        <h3>Progress Dashboard</h3>
        <div id="completionBarContainer" style="background: #ddd; width: 100%; height: 20px; border-radius: 5px;">
            <div id="completionBar" style="background: #4caf50; height: 100%; width: 0%; border-radius: 5px;"></div>
        </div>
        <p>
            Completed Tasks: <span id="completedCount">0</span> /
            <span id="totalCount"><?= count($tasks) ?></span><br />
            Completion Percentage: <span id="completionPercentage">0%</span>
        </p>
    </div>
</div>

<script src="../../asset/js/progressTrack.js"></script>

</body>
</html>