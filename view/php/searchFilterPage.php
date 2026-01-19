<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Search & Filter System</title>
        <link rel="stylesheet" href="../../asset/css/searchFilterStyle.css" />
        <link rel="icon" type="image/png" href="../../asset/imgs/icon.png">
    </head>

    <body>
        <form id="sf" method="get" enctype="multipart/form-data">
            <div class="container">
                <h1>Search | Filter</h1>

                <div class="controls">
                    <input type="text" id="searchInput" placeholder="Search by keyword..." />
                    <select id="categoryFilter">
                        <option value="all">All Categories</option>
                        <option value="development">Development</option>
                        <option value="design">Design</option>
                        <option value="marketing">Marketing</option>
                    </select>
                    <button type="button" id="searchButton">Search</button>
                </div>

                <div id="resultsList" class="results-list"></div>
            </div>
        </form>

        <script src="../../asset/js/searchFilter.js"></script>
    </body>
</html>
