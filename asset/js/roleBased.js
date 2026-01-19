let users = []; 
let selectedUserIndex = null;


function initializeRoleBasedApp() {

    if (typeof initialUsersData !== 'undefined' && Array.isArray(initialUsersData)) {
        users = initialUsersData;
    } else {
        console.warn("initialUsersData not found or is not an array. Fetching users via AJAX on load.");
        fetchUsersFromDatabase();
    }
    renderUserList();
    addClickListenersToUserList();
}

async function fetchUsersFromDatabase() {
    const response = await fetch('../../controller/roleController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'action=getAllUsers', 
    });
    const result = await response.json();
    if (result.success) {
        users = result.users;
        renderUserList();
        addClickListenersToUserList();
    } else {
        alert('Failed to load users: ' + result.message);
    }
}


function renderUserList(filter = "all") {
    const box = document.getElementById("userScrollBox");
    box.innerHTML = "";
    users.forEach((user, i) => {
        if (filter === "all" || user.role === filter) {
            const div = document.createElement("div");
            div.textContent = user.firstname + " " + user.lastname + " (" + user.role + ")";
            div.setAttribute('data-user-index', i); 
            box.appendChild(div);
        }
    });
    addClickListenersToUserList(); 
}

function addClickListenersToUserList() {
    const userDivs = document.querySelectorAll('#userScrollBox > div');
    userDivs.forEach(div => {
        div.onclick = () => {
            const index = parseInt(div.getAttribute('data-user-index'));
            showUserInfo(index);
        };
    });
}

function showUserInfo(index) {
    selectedUserIndex = index;
    const user = users[index];
    const infoBox = document.getElementById("userDetails");
    infoBox.innerHTML = `
        <strong>Name:</strong> ${user.firstname} ${user.lastname}<br>
        <strong>Email:</strong> ${user.email}<br>
        <strong>Role:</strong> ${user.role}
    `;
    document.getElementById("newRole").value = user.role;
}

function filterUsersByRole() {
    const role = document.getElementById("roleSelect").value;
    renderUserList(role);
}

async function updateUserRole() {
    if (selectedUserIndex === null) return;
    const newRole = document.getElementById("newRole").value;
    const userIdToUpdate = users[selectedUserIndex].id;

    const response = await fetch('../../controller/roleController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=updateRole&userId=${userIdToUpdate}&newRole=${newRole}`,
    });

    const result = await response.json();

    if (result.success) {
        users[selectedUserIndex].role = newRole;
        renderUserList(document.getElementById("roleSelect").value);
        showUserInfo(selectedUserIndex);
        alert('User role updated successfully!');
    } else {
        alert('Failed to update user role: ' + result.message);
    }
}

window.addEventListener('DOMContentLoaded',initializeRoleBasedApp);