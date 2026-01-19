<?php
session_start();
if (empty($_SESSION['userID'])) {
    header('Location: ../view/php/loginPage.php');
    exit;
}

require_once('../../model/userModel.php');

$users = getAllUsers();
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Role Management Dashboard</title>
    <link rel="stylesheet" href="../../asset/css/roleBasedStyle.css">
  </head>
  <body>
    <div class="wrapper">
      <header>
        <h1>Role Management</h1>
      </header>

      <div class="admin-controls">
        <label for="roleSelect">Select Role:</label>
        <select id="roleSelect" onchange="filterUsersByRole()">
          <option value="all">All</option>
          <option value="Admin">Admin</option>
          <option value="User">User</option>
        </select>
      </div>

      <div class="content">
        <div class="user-list">
          <h2>Users</h2>
          <div id="userScrollBox" class="scrollbox">
            <?php
            if (!empty($users)) {
                foreach ($users as $index => $user) {
                    echo "<div data-user-index=\"{$index}\">" . htmlspecialchars($user['firstname'] . ' ' . $user['lastname']) . " (" . htmlspecialchars($user['role']) . ")</div>";
                }
            } else {
                echo "<div>No users found.</div>";
            }
            ?>
          </div>
        </div>

        <div class="user-info">
          <h2>User Info</h2>
          <div id="userDetails" class="info-box">Select a user to view details</div>

          <div class="role-update">
            <label for="newRole">Change Role:</label>
            <select id="newRole">
              <option value="Admin">Admin</option>
              <option value="User">User</option>
            </select>
            <button onclick="updateUserRole()">Update Role</button>
          </div>
        </div>
      </div>
    </div>

    <script>
        const initialUsersData = <?php echo json_encode($users); ?>;
    </script>
    <script src="../../asset/js/roleBased.js"></script>
  </body>
</html>