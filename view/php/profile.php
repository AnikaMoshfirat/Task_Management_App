<?php
session_start();
require_once('../../model/db.php');

if(empty($_SESSION['status']) || empty($_SESSION['email'])) {
    header('Location: ../view/html/loginPage.html');
    exit;
}

$editErrors = [];
$passwordErrors = [];

$conn = getConnection();
if(!$conn) {
    die("Database connection failed!");
}
$email = $_SESSION['email'];

$sql = "SELECT firstname, lastname, email, phone, DOB, address, selfImage FROM userinfos WHERE email = ?";
$stmt = $conn->prepare($sql);

if(!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $profileImage = !empty($user['selfImage']) ? '../../' . $user['selfImage'] : "../../asset/imgs/defaultImg.png";
    $_SESSION['profile_Image'] = $profileImage;
    $_SESSION['firstname'] = trim($user['firstname']);
    $_SESSION['lastname'] = trim($user['lastname']);
    $_SESSION['email'] = trim($user['email']);
    $_SESSION['phone'] = trim($user['phone']);
    $_SESSION['dob'] = trim($user['DOB']);
    $_SESSION['address'] = trim($user['address']);
} else {
    header('Location: ../view/html/loginPage.html');
    exit;
}

$stmt->close();
$conn->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['edit-profile'])) {
        $firstName = trim($_POST['edit-first-name']);
        $lastName = trim($_POST['edit-last-name']);
        $email = trim($_POST['edit-email']);
        $phone = trim($_POST['edit-phone']);
        $dob = trim($_POST['edit-dob']);
        $address = trim($_POST['edit-address']);

        if (empty($firstName) || empty($lastName) || empty($email)) {
            $editErrors[] = "First Name, Last Name, and Email are required.";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $editErrors[] = "Invalid email format.";
        }
        if (empty($editErrors)) {
            //updateUser Profile();
        }
    }
    if (isset($_POST['reset-password'])) {
        $currentPassword = trim($_POST['current-password']);
        $newPassword = trim($_POST['new-password']);
        $confirmPassword = trim($_POST['confirm-password']);

        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            $passwordErrors[] = "All password fields are required.";
        }
        if ($newPassword !== $confirmPassword) {
            $passwordErrors[] = "New Password and Confirm Password do not match.";
        }
        if (empty($passwordErrors)) {
            //updateUser Password();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | TM</title>
    <link rel="icon" type="image/png" href="../../asset/imgs/icon.png">
    <link rel="stylesheet" href="../../asset/css/profileStyle.css">
</head>
<body>
    <div class="profile-container">
        <div class="profile-header">
            <img alt="Profile Image" class="profileImg" src="<?php echo $_SESSION['profile_Image']; ?> " height="60" width="auto">
            <h2><?php echo $_SESSION['name']; ?></h2>
            <p><?php echo $_SESSION['email']; ?></p>
        </div>

        <div class="tab-container">
            <div class="tab active" data-tab="view">View Profile</div>
            <div class="tab" data-tab="edit">Edit Profile</div>
            <div class="tab" data-tab="avatar">Change Avatar</div>
            <div class="tab" data-tab="password">Reset Password</div>
        </div>

        <div class="tab-content active" id="view-tab">
            <div class="profile-section">
                <h3>Personal Information</h3>
                <div class="profile-info">
                    <div class="info-item">
                        <label>First Name</label>
                        <span class="firstName"><?php echo $_SESSION['firstname']; ?></span>
                    </div>
                    <div class="info-item">
                        <label>Last Name</label>
                        <span class="lastName"><?php echo $_SESSION['lastname']; ?></span>
                    </div>
                    <div class="info-item">
                        <label>Email</label>
                        <span class="email"><?php echo $_SESSION['email']; ?></span>
                    </div>
                    <div class="info-item">
                        <label>Phone</label>
                        <span class="phone"><?php echo $_SESSION['phone']; ?></span>
                    </div>
                    <div class="info-item">
                        <label>Date of Birth</label>
                        <span class="dob"><?php echo $_SESSION['dob']; ?></span>
                    </div>
                    <div class="info-item">
                        <label>Address</label>
                        <span class="address"><?php echo $_SESSION['address']; ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-content" id="edit-tab">
            <div class="profile-section">
                <h3>Edit Profile</h3>
                <?php if (!empty($editErrors)): ?>
                    <div class="error-messages">
                        <?php foreach ($editErrors as $error): ?>
                            <p><?php echo htmlspecialchars($error); ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <form id="edit-profile-form" method="POST">
                    <div class="profile-info">
                        <div class="input-group">
                            <label for="edit-first-name">First Name</label>
                            <input type="text" id="edit-first-name" name="edit-first-name" value="" required>
                        </div>
                        <div class="input-group">
                            <label for="edit-last-name">Last Name</label>
                            <input type="text" id="edit-last-name" name="edit-last-name" value="" required>
                        </div>
                        <div class="input-group">
                            <label for="edit-email">Email</label>
                            <input type="email" id="edit-email" name="edit-email" value="" required>
                        </div>
                        <div class="input-group">
                            <label for="edit-phone">Phone</label>
                            <input type="tel" id="edit-phone" name="edit-phone" value="">
                        </div>
                        <div class="input-group">
                            <label for="edit-dob">Date of Birth</label>
                            <input type="date" id="edit-dob" name="edit-dob" value="">
                        </div>
                        <div class="input-group">
                            <label for="edit-address">Address</label>
                            <textarea id="edit-address" name="edit-address" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="cancel" id="cancel-edit">Cancel</button>
                        <button type="submit" name="edit-profile">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="tab-content" id="avatar-tab">
            <div class="profile-section">
                <h3>Change Avatar</h3>
                <div style="text-align: center;">
                    <p>Current Avatar:</p>
                    <img src="imgs/cr7.png" alt="Current Avatar" style="width: 150px; height: 150px; border-radius: 50%; margin: 10px 0;">
                    <input type="file" id="avatar-upload" accept="image/*" style="display: none;">
                    <button type="button" id="upload-avatar-btn">Upload New Avatar</button>
                    <p class="message" id="avatar-message"></p>
                </div>
            </div>
        </div>

        <div class="tab-content" id="password-tab">
            <div class="profile-section">
                <h3>Reset Password</h3>
                <?php if (!empty($passwordErrors)): ?>
                    <div class="error-messages">
                        <?php foreach ($passwordErrors as $error): ?>
                            <p><?php echo htmlspecialchars($error); ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <form id="reset-password-form" method="POST">
                    <div class="input-group">
                        <label for="current-password">Current Password</label>
                        <div class="password-wrapper">
                            <input type="password" id="current-password" name="current-password" required>
                            <span toggle="#current-password" class="toggle-password">👁️</span>
                        </div>
                    </div>
                    <div class="input-group">
                        <label for="new-password">New Password</label>
                        <div class="password-wrapper">
                            <input type="password" id="new-password" name="new-password" required>
                            <span toggle="#new-password" class="toggle-password">👁️</span>
                        </div>
                    </div>
                    <div class="input-group">
                        <label for="confirm-password">Confirm New Password</label>
                        <div class="password-wrapper">
                            <input type="password" id="confirm-password" name="confirm-password" required>
                            <span toggle="#confirm-password" class="toggle-password">👁️</span>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" name="reset-password">Change Password</button>
                    </div>
                    <div class="message" id="password-message"></div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" id="avatar-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Crop Your Avatar</h3>
                <button class="close-modal">&times;</button>
            </div>
            <div class="crop-area">
                <img id="avatar-preview" src="" alt="Preview">
            </div>
            <div class="modal-actions">
                <button class="cancel" id="cancel-crop">Cancel</button>
                <button id="save-avatar">Save Avatar</button>
            </div>
        </div>
    </div>

    <script src="../../asset/js/profile.js"></script>
</body>
</html>
