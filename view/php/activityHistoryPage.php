<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Activity History</title>
        <link rel="stylesheet" href="../../asset/css/activityHistoryStyle.css" />
        <link rel="icon" type="image/png" href="../../asset/imgs/icon.png">
    </head>

    <body>
        <div class="container">
            <h1>Activity | History</h1>

            <div class="controls">
                <input type="text" id="searchInput" placeholder="Search tasks...">
                <select id="categoryFilter">
                    <option value="all">All Categories</option>
                    </select>
                <button id="searchButton">Search</button>
            </div>

            <div id="resultsList" class="results-list"></div>
        </div>

        <script src="../../asset/js/activityHistory.js"></script>
    </body>
</html>