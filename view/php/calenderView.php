<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Calendar | TM</title>
    <link rel="stylesheet" href="../../asset/css/calenderView.css" />
</head>
<body>
    <div class="calendarContainer">
        <div class="calendarHeader">
            <h2>Weekly Calendar</h2>
            <div class="calendarTabs">
                <button onclick="loadWeek(-1)">Prev</button>
                <button onclick="loadWeek(0)">This Week</button>
                <button onclick="loadWeek(1)">Next</button>
                <button onclick="window.print()">Print</button>
            </div>
        </div>
        <div class="calendarGrid" id="calendarGrid"></div>
    </div>

    <script src="../../asset/js/calenderView.js"></script>
</body>
</html>