<?php
session_start(); 
//error_reporting(E_ALL); 

require_once('../model/userModel.php'); 


function validateEmail($email) {
    $email = trim($email);
    if (empty($email)) {
        return "Email is required.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Invalid email format.";
    }
    return null; 
}


function validatePassword($password) {
    $password = trim($password);
    if (empty($password)) {
        return "Password is required.";
    }
    if (strlen($password) < 8) {
        return "Password must be at least 8 characters long.";
    }
    return null; 
}


function authUser($email, $password) {
    $user = getUserByEmail($email);

    if (!$user) {
        $_SESSION['login_message'] = "Invalid email or password."; 
        $_SESSION['message_type'] = "error";
        header("Location: ../view/php/loginPage.php"); 
        exit;
    }

    if (!password_verify($password, $user['password'])) {
        $_SESSION['login_message'] = "Invalid email or password."; 
        $_SESSION['message_type'] = "error";
        header("Location: ../view/php/loginPage.php"); 
        exit;
    }

    $_SESSION['status'] = true; 
    $_SESSION['userID'] = $user['id'];
    $_SESSION['email'] = $email;
    $_SESSION['name'] = $user['firstname'] . ' ' . $user['lastname'];
    $_SESSION['profile_img'] = !empty($user['selfImage']) ? $user['selfImage'] : 'asset/imgs/defaultImgs.png';

    $role = getUserRoleById($user['id']);
    if (!$role) {
        error_log("Login Error: Role not found for User ID: " . $user['id']);
        $_SESSION['login_message'] = "An unexpected error occurred. Please try again later.";
        $_SESSION['message_type'] = "error";
        header("Location: ../view/php/loginPage.php");
        exit;
    }
    $_SESSION['role'] = $role;

    setcookie('status', 'true', time() + (86400 * 30), '/'); //30 days (86400 seconds * 30)

    if ($role === 'Admin') {
        header("Location: ../view/php/adminMenu.php");
    } elseif ($role === 'User') {
        header("Location: ../view/php/userMenu.php");
    } else {
        error_log("Login Error: Unknown role '$role' for User ID: " . $user['id']);
        $_SESSION['login_message'] = "An unexpected role was encountered. Please contact support.";
        $_SESSION['message_type'] = "error";
        header("Location: ../view/php/loginPage.php");
    }
    exit; 
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password'] ?? '');

    $emailError = validateEmail($email);
    $passwordError = validatePassword($password);

    if ($emailError || $passwordError) {
        $errorMessage = '';
        if ($emailError) {
            $errorMessage .= $emailError . ' ';
        }
        if ($passwordError) {
            $errorMessage .= $passwordError;
        }
        $_SESSION['login_message'] = trim($errorMessage); 
        $_SESSION['message_type'] = "error";
        header("Location: ../view/php/loginPage.php"); 
        exit;
    }

    authUser($email, $password);

} else {
    $_SESSION['login_message'] = "Unauthorized access.";
    $_SESSION['message_type'] = "error";
    header("Location: ../view/php/loginPage.php");
    exit;
}
?>