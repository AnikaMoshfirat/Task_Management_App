function toggleAdvanced() {
    const form = document.getElementById('advancedForm');
    form.style.display = (form.style.display === 'block') ? 'none' : 'block';
}

function toggleCategoryManager() {
    const manager = document.getElementById('categoryManager');
    manager.style.display = (manager.style.display === 'block') ? 'none' : 'block';
}

function quickAddTask() {
    const quickInput = document.getElementById('quickTaskInput');
    const name = quickInput.value.trim();
    if (!name) {
        showToast('Please enter a task name.', true);
        return;
    }
    showToast(`Task "${name}" added successfully!`);
    quickInput.value = '';
}

function showToast(message, isError = false) {
    const toast = document.getElementById('toast');
    toast.textContent = message;
    toast.className = 'toast ' + (isError ? 'error' : 'success');
    toast.style.display = 'block';
    setTimeout(() => { toast.style.display = 'none'; }, 3000);
}

// --- Task and Subtask AJAX Logic ---
document.addEventListener('DOMContentLoaded', function() {
    loadTasks();
});

function loadTasks() {
    const container = document.getElementById('taskLists');
    container.innerHTML = '<p>Loading tasks...</p>';
    const xhr = new XMLHttpRequest();
    xhr.open('GET', '../../controller/viewTaskController.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            let tasks = [];
            try {
                tasks = JSON.parse(xhr.responseText);
            } catch (e) {
                container.innerHTML = '<p>Error loading tasks.</p>';
                return;
            }
            renderTasks(tasks);
        } else {
            container.innerHTML = '<p>Error loading tasks.</p>';
        }
    };
    xhr.send();
}

function renderTasks(tasks) {
    const container = document.getElementById('taskLists');
    if (!tasks.length) {
        container.innerHTML = '<p>No tasks found.</p>';
        return;
    }
    container.innerHTML = '';
    tasks.forEach(task => {
        const taskDiv = document.createElement('div');
        taskDiv.className = 'task-item';
        taskDiv.innerHTML = `
            <div class="task-header">
                <strong>${task.taskName}</strong> <span>(${task.taskCategory})</span>
                <button onclick="showSubtaskInput(${task.taskID})">+ Subtask</button>
            </div>
            <div class="task-desc">${task.taskDesc || ''}</div>
            <div class="subtask-list" id="subtasks-${task.taskID}"></div>
            <div class="subtask-input" id="subtask-input-${task.taskID}" style="display:none;">
                <input type="text" id="subtaskName-${task.taskID}" placeholder="Subtask name" />
                <input type="text" id="subtaskDesc-${task.taskID}" placeholder="Subtask description" />
                <button onclick="addSubtask(${task.taskID})">Add</button>
                <button onclick="hideSubtaskInput(${task.taskID})">Cancel</button>
            </div>
        `;
        container.appendChild(taskDiv);
        loadSubtasks(task.taskID);
    });
}

function showSubtaskInput(taskID) {
    document.getElementById(`subtask-input-${taskID}`).style.display = 'block';
}
function hideSubtaskInput(taskID) {
    document.getElementById(`subtask-input-${taskID}`).style.display = 'none';
}

function loadSubtasks(taskID) {
    const subtaskDiv = document.getElementById(`subtasks-${taskID}`);
    subtaskDiv.innerHTML = '<em>Loading subtasks...</em>';
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `../../controller/subtaskController.php?action=get&taskID=${taskID}`, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            let data = {};
            try {
                data = JSON.parse(xhr.responseText);
            } catch (e) {
                subtaskDiv.innerHTML = '<em>Error loading subtasks.</em>';
                return;
            }
            if (data.success && data.subtasks) {
                renderSubtasks(taskID, data.subtasks);
            } else {
                subtaskDiv.innerHTML = '<em>No subtasks found.</em>';
            }
        } else {
            subtaskDiv.innerHTML = '<em>Error loading subtasks.</em>';
        }
    };
    xhr.send();
}

function renderSubtasks(taskID, subtasks) {
    const subtaskDiv = document.getElementById(`subtasks-${taskID}`);
    if (!subtasks.length) {
        subtaskDiv.innerHTML = '<em>No subtasks.</em>';
        return;
    }
    subtaskDiv.innerHTML = '';
    subtasks.forEach(subtask => {
        const subDiv = document.createElement('div');
        subDiv.className = 'subtask-item';
        subDiv.innerHTML = `
            <input type="checkbox" onchange="setSubtaskDone(${subtask.subtaskID}, this.checked)" ${subtask.isDone ? 'checked' : ''} />
            <span class="subtask-name ${subtask.isDone ? 'done' : ''}">${subtask.subtaskName}</span>
            <span class="subtask-desc">${subtask.subtaskDesc || ''}</span>
            <button onclick="editSubtaskPrompt(${subtask.subtaskID}, ${taskID}, '${encodeURIComponent(subtask.subtaskName)}', '${encodeURIComponent(subtask.subtaskDesc || '')}')">Edit</button>
            <button onclick="deleteSubtask(${subtask.subtaskID}, ${taskID})">Delete</button>
        `;
        subtaskDiv.appendChild(subDiv);
    });
}

function addSubtask(taskID) {
    const name = document.getElementById(`subtaskName-${taskID}`).value.trim();
    const desc = document.getElementById(`subtaskDesc-${taskID}`).value.trim();
    if (!name) {
        showToast('Subtask name required.', true);
        return;
    }
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../../controller/subtaskController.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            let data = {};
            try { data = JSON.parse(xhr.responseText); } catch (e) {}
            if (data.success) {
                showToast('Subtask added!');
                hideSubtaskInput(taskID);
                loadSubtasks(taskID);
            } else {
                showToast('Failed to add subtask.', true);
            }
        }
    };
    xhr.send(`action=add&taskID=${taskID}&subtaskName=${encodeURIComponent(name)}&subtaskDesc=${encodeURIComponent(desc)}`);
}

function setSubtaskDone(subtaskID, isDone) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../../controller/subtaskController.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            let data = {};
            try { data = JSON.parse(xhr.responseText); } catch (e) {}
            if (!data.success) showToast('Failed to update subtask.', true);
        }
    };
    xhr.send(`action=setDone&subtaskID=${subtaskID}&isDone=${isDone ? 1 : 0}`);
}

function deleteSubtask(subtaskID, taskID) {
    if (!confirm('Delete this subtask?')) return;
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../../controller/subtaskController.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            let data = {};
            try { data = JSON.parse(xhr.responseText); } catch (e) {}
            if (data.success) {
                showToast('Subtask deleted!');
                loadSubtasks(taskID);
            } else {
                showToast('Failed to delete subtask.', true);
            }
        }
    };
    xhr.send(`action=delete&subtaskID=${subtaskID}`);
}

function editSubtaskPrompt(subtaskID, taskID, name, desc) {
    name = decodeURIComponent(name);
    desc = decodeURIComponent(desc);
    const newName = prompt('Edit subtask name:', name);
    if (newName === null) return;
    const newDesc = prompt('Edit subtask description:', desc);
    if (newDesc === null) return;
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../../controller/subtaskController.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            let data = {};
            try { data = JSON.parse(xhr.responseText); } catch (e) {}
            if (data.success) {
                showToast('Subtask updated!');
                loadSubtasks(taskID);
            } else {
                showToast('Failed to update subtask.', true);
            }
        }
    };
    xhr.send(`action=update&subtaskID=${subtaskID}&subtaskName=${encodeURIComponent(newName)}&subtaskDesc=${encodeURIComponent(newDesc)}`);
}


