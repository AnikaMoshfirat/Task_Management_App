function getMonday(date) {
    var d = new Date(date);
    var day = d.getDay();
    var diff = d.getDate() - day + (day === 0 ? -6 : 1);
    return new Date(d.setDate(diff));
}

function formatDate(date) {
    var year = date.getFullYear();
    var month = (date.getMonth() + 1).toString().padStart(2, "0");
    var day = date.getDate().toString().padStart(2, "0");
    return year + "-" + month + "-" + day;
}

function loadWeek(weekOffset) {
    var today = new Date();
    var monday = getMonday(today);
    monday.setDate(monday.getDate() + weekOffset * 7);
    var mondayStr = formatDate(monday);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../../controller/calenderController.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                try {
                    var tasks = JSON.parse(xhr.responseText);
                    var grid = document.getElementById("calendarGrid");
                    grid.innerHTML = "";

                    var days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];

                    for (var i = 0; i < 7; i++) {
                        var cellDate = new Date(monday);
                        cellDate.setDate(monday.getDate() + i);
                        var cellDateStr = formatDate(cellDate);

                        var cell = document.createElement("div");
                        cell.className = "calendarCell";
                        cell.innerHTML = "<strong>" + days[i] + "</strong><br><small>" + cellDateStr + "</small>";

                        for (var j = 0; j < tasks.length; j++) {
                            var taskDate = tasks[j].startTime.split(" ")[0]; 
                            if (taskDate === cellDateStr) {
                                var taskDiv = document.createElement("div");
                                taskDiv.className = "task";
                                taskDiv.innerHTML =
                                    "<strong>" + tasks[j].taskName + "</strong><br>" +
                                    "<small>" + tasks[j].taskCategory + "</small><br>" +
                                    "<small>" + tasks[j].startTime.split(" ")[1].slice(0, 5) + "</small><br>" +
                                    "<small>Status: " + (tasks[j].isDone == 1 ? "Completed" : "Pending") + "</small>";
                                cell.appendChild(taskDiv);
                            }
                        }
                        grid.appendChild(cell);
                    }
                } catch (e) {
                    console.error("Error parsing JSON response or rendering tasks:", e);
                    document.getElementById("calendarGrid").innerHTML = "<div style='color:red;'>Error loading tasks.</div>";
                }
            } else {
                console.error("XHR request failed with status:", xhr.status);
                document.getElementById("calendarGrid").innerHTML = "<div style='color:red;'>Failed to load tasks. Server error.</div>";
            }
        }
    };

    xhr.send("monday=" + mondayStr);
}

window.onload = function () {
    loadWeek(0);
};