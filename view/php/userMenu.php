<?php
session_start();
require_once('../../model/db.php');

if(empty($_SESSION['userID']) || empty($_SESSION['email'])) {
    header('Location: ../view/html/loginPage.html');
    exit;
}

$conn = getConnection();
if (!$conn) {
    echo "Database connection failed!";
}

$email = $_SESSION['email'];

$sql = "SELECT firstname, lastname, selfImage FROM userinfos WHERE email = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $profileImage = !empty($user['selfImage']) ? '../../' . htmlspecialchars($user['selfImage']) : "../../asset/imgs/defaultImg.png";
    $_SESSION['profile_Image'] = $profileImage;
    $_SESSION['name'] = htmlspecialchars(trim($user['firstname'] . ' ' . $user['lastname']));
} else {
    header('Location: ../view/html/loginPage.html');
    exit;
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Menu | TM</title>
    <link rel="stylesheet" href="../../asset/css/userMenuStyle.css" />
    <link rel="icon" type="image/png" href="../../asset/imgs/icon.png" />
</head>
<body>
    <header class="topBar">
        <div class="userHeadInfo">
            <img
                alt="Profile Image"
                class="profileImg"
                src="<?php echo $_SESSION['profile_Image']; ?>"
                height="50"
                width="auto"
                loading="lazy"
            />
            <span class="profileName"><?php echo $_SESSION['name']; ?></span>
        </div>
        <button class="logoutBtn" onclick="logout()">Logout</button>
    </header>
    <div class="layout">
        <aside class="sidebar" id="sidebar">
            <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
            <nav class="nav-buttons">
                <button onclick="showContent('../html/dashboard.html')">Dashboard</button>
                <button onclick="showContent('../php/profile.php')">Profile</button>
                <button onclick="showContent('../php/taskcreation.php')">Create Task</button>
                <button onclick="showContent('../php/progressTrackPage.php')">Progress Tracker</button>
                <button onclick="showContent('../php/searchFilterPage.php')">Search & Filter</button>
                <button onclick="showContent('../php/activityHistoryPage.php')">Activity History</button>
                <button onclick="showContent('../php/calenderView.php')">Calendar View</button>
            </nav>
        </aside>
        <main class="main-content">
            <iframe id="contentFrame" src="../html/dashboard.html" frameborder="0"></iframe>
        </main>
    </div>
    <script src="../../asset/js/userMenu.js"></script>
</body>
</html>
