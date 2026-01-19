document.addEventListener("DOMContentLoaded", () => {
    let data = [];

    const searchInput = document.getElementById("searchInput");
    const categoryFilter = document.getElementById("categoryFilter");
    const searchButton = document.getElementById("searchButton");
    const resultsList = document.getElementById("resultsList");

    function renderResults(filteredData) {
        resultsList.innerHTML = "";

        if (filteredData.length === 0) {
            resultsList.innerHTML = "<p>No results found.</p>";
            return;
        }

        filteredData.forEach(item => {
            const start = new Date(item.startTime);
            const end = new Date(item.endTime);

            const div = document.createElement("div");
            div.classList.add("result-item");

            const statusClass = (item.isDone == "1" || item.isDone == 1) ? "status-completed" : "status-not-completed";
            const statusText = (item.isDone == "1" || item.isDone == 1) ? "Completed ✅" : "Not Completed ❌";

            div.innerHTML = `
                <div>
                    <strong>${item.taskName}</strong><br/>
                    <span class="category">Category: ${item.taskCategory}</span><br/>
                    <span class="datetime">Start: ${start.toLocaleString()}</span><br/>
                    <span class="datetime">Deadline: ${end.toLocaleString()}</span>
                    <span class="${statusClass}">Status: ${statusText}</span>
                </div>
            `;
            resultsList.appendChild(div);
        });
    }

    function filterData() {
        const keyword = searchInput.value.toLowerCase();
        const selectedCategory = categoryFilter.value;

        const filtered = data.filter(item => {
            const matchesKeyword = item.taskName.toLowerCase().includes(keyword);
            const matchesCategory = selectedCategory === "all" || item.taskCategory === selectedCategory;
            return matchesKeyword && matchesCategory;
        });

        renderResults(filtered);
    }

    function fetchData() {
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "../../controller/activityHistoryController.php", true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                try {
                    data = JSON.parse(xhr.responseText);
                    renderResults(data);
                    populateCategoryFilter(data);
                } catch (err) {
                    resultsList.innerHTML = "<p>Error parsing data from server.</p>";
                    console.error("Parsing error:", err);
                }
            } else {
                resultsList.innerHTML = "<p>Error loading data from server. Status: " + xhr.status + "</p>";
                console.error("XHR failed with status:", xhr.status, xhr.statusText);
            }
        };
        xhr.onerror = function() {
            resultsList.innerHTML = "<p>Network error while fetching data.</p>";
            console.error("Network error.");
        };
        xhr.send();
    }

    function populateCategoryFilter(data) {
        const categories = new Set();
        data.forEach(item => {
            if (item.taskCategory) {
                categories.add(item.taskCategory);
            }
        });

        categoryFilter.innerHTML = '<option value="all">All Categories</option>';
        categories.forEach(category => {
            const option = document.createElement("option");
            option.value = category;
            option.textContent = category;
            categoryFilter.appendChild(option);
        });
    }

    searchButton.addEventListener("click", filterData);
    searchInput.addEventListener("keypress", e => {
        if (e.key === "Enter") {
            e.preventDefault();
            filterData();
        }
    });
    categoryFilter.addEventListener("change", filterData);

    fetchData();
});