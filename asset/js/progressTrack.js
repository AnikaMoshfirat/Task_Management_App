document.addEventListener('DOMContentLoaded', function() {
    const completedCountSpan = document.getElementById('completedCount');
    const totalCountSpan = document.getElementById('totalCount');
    const completionPercentageSpan = document.getElementById('completionPercentage');
    const completionBar = document.getElementById('completionBar');
    const taskForm = document.getElementById('taskForm');

    function updateProgress() {
        const currentTaskCheckboxes = document.querySelectorAll('.task-checkbox');
        let completedTasks = 0;
        const totalTasks = currentTaskCheckboxes.length;

        currentTaskCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                completedTasks++;
            }
        });

        completedCountSpan.textContent = completedTasks;
        totalCountSpan.textContent = totalTasks;

        const percentage = totalTasks === 0 ? 0 : (completedTasks / totalTasks) * 100;
        completionPercentageSpan.textContent = percentage.toFixed(2) + '%';
        completionBar.style.width = percentage + '%';
    }

    function updateTask(taskID, isDone) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../../controller/taskController.php', true);
        xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    try {
                        const res = JSON.parse(xhr.responseText);
                        if (!res.success) {
                            alert('Update unsuccessful. Reverting checkbox state.');
                            fetchAndUpdateTasks(); 
                        } else {
                            updateProgress(); 
                        }
                    } catch (e) {
                        alert('Invalid response from server. Reverting checkbox state.');
                        fetchAndUpdateTasks();
                    }
                } else {
                    alert('Failed to update task. Please try again. Reverting checkbox state.');
                    fetchAndUpdateTasks();
                }
            }
        };

        xhr.send(JSON.stringify({ taskID: taskID, isDone: isDone ? 1 : 0 }));
    }

    function fetchAndUpdateTasks() {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', '../../controller/taskController.php', true);

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                try {
                    const tasks = JSON.parse(xhr.responseText);
                    tasks.forEach(task => {
                        const cb = document.querySelector(`.task-checkbox[data-taskid="${task.taskID}"]`);
                        if (cb) {
                            cb.checked = (task.isDone === 1);
                        }
                    });
                    updateProgress(); 
                } catch (e) {
                    alert('Failed to parse tasks data.');
                }
            }
        };
        xhr.send();
    }
    taskForm.addEventListener('change', function(event) {
        if (event.target.classList.contains('task-checkbox')) {
            const checkbox = event.target;
            const taskID = checkbox.dataset.taskid;
            const isDone = checkbox.checked;
            updateTask(taskID, isDone);
        }
    });

    fetchAndUpdateTasks();
});