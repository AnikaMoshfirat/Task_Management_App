// --- Admin Panel AJAX Logic ---
document.addEventListener('DOMContentLoaded', function() {
    loadUsers();
    loadTasks();
    loadActivityLogs();
});

function loadUsers() {
    const userList = document.getElementById('userList');
    userList.innerHTML = 'Loading users...';
    fetch('../../controller/adminController.php?action=getUsers')
        .then(res => res.json())
        .then(data => {
            if (data.success && data.users) renderUsers(data.users);
            else userList.innerHTML = 'No users found.';
        })
        .catch(() => { userList.innerHTML = 'Error loading users.'; });
}

function renderUsers(users) {
    const userList = document.getElementById('userList');
    if (!users.length) { userList.innerHTML = 'No users.'; return; }
    let html = '<table class="admin-table"><tr><th>Name</th><th>Email</th><th>Role</th><th>Actions</th></tr>';
    users.forEach(user => {
        html += `<tr>
            <td>${user.firstname} ${user.lastname}</td>
            <td>${user.email}</td>
            <td><select onchange="changeUserRole(${user.ID}, this.value)">
                <option value="User" ${user.role === 'User' ? 'selected' : ''}>User</option>
                <option value="Admin" ${user.role === 'Admin' ? 'selected' : ''}>Admin</option>
            </select></td>
            <td>
                <button class="admin-action-btn" onclick="deleteUser(${user.ID})">Delete</button>
            </td>
        </tr>`;
    });
    html += '</table>';
    userList.innerHTML = html;
}

function changeUserRole(userID, newRole) {
    fetch('../../controller/adminController.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=changeRole&userID=${userID}&newRole=${newRole}`
    })
    .then(res => res.json())
    .then(data => { if (data.success) loadUsers(); })
    .catch(() => {});
}

function deleteUser(userID) {
    if (!confirm('Delete this user?')) return;
    fetch('../../controller/adminController.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=deleteUser&userID=${userID}`
    })
    .then(res => res.json())
    .then(data => { if (data.success) loadUsers(); })
    .catch(() => {});
}

function loadTasks() {
    const taskList = document.getElementById('taskList');
    taskList.innerHTML = 'Loading tasks...';
    fetch('../../controller/adminController.php?action=getTasks')
        .then(res => res.json())
        .then(data => {
            if (data.success && data.tasks) renderTasks(data.tasks);
            else taskList.innerHTML = 'No tasks found.';
        })
        .catch(() => { taskList.innerHTML = 'Error loading tasks.'; });
}

function renderTasks(tasks) {
    const taskList = document.getElementById('taskList');
    if (!tasks.length) { taskList.innerHTML = 'No tasks.'; return; }
    let html = '<table class="admin-table"><tr><th>Name</th><th>User</th><th>Status</th><th>Actions</th></tr>';
    tasks.forEach(task => {
        html += `<tr>
            <td>${task.taskName}</td>
            <td>${task.userName}</td>
            <td>${task.isDone ? 'Done' : 'Pending'}</td>
            <td>
                <button class="admin-action-btn" onclick="deleteTask(${task.taskID})">Delete</button>
            </td>
        </tr>`;
    });
    html += '</table>';
    taskList.innerHTML = html;
}

function deleteTask(taskID) {
    if (!confirm('Delete this task?')) return;
    fetch('../../controller/adminController.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=deleteTask&taskID=${taskID}`
    })
    .then(res => res.json())
    .then(data => { if (data.success) loadTasks(); })
    .catch(() => {});
}

function loadActivityLogs() {
    const logList = document.getElementById('activityLogList');
    logList.innerHTML = 'Loading logs...';
    fetch('../../controller/adminController.php?action=getLogs')
        .then(res => res.json())
        .then(data => {
            if (data.success && data.logs) renderLogs(data.logs);
            else logList.innerHTML = 'No logs found.';
        })
        .catch(() => { logList.innerHTML = 'Error loading logs.'; });
}

function renderLogs(logs) {
    const logList = document.getElementById('activityLogList');
    if (!logs.length) { logList.innerHTML = 'No logs.'; return; }
    let html = '<ul>';
    logs.forEach(log => {
        html += `<li>${log.timestamp}: ${log.message}</li>`;
    });
    html += '</ul>';
    logList.innerHTML = html;
} 