<?php

require_once 'db.php';

function login($user){
    $conn = getConnection();
    $sql = "SELECT id FROM userinfos WHERE email = '{$user['username']}' AND password = '{$user['password']}'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        return $row['id'];
    } else {
        return false;
    }

}

function getAllUsers(){
    $conn = getConnection();
    $sql = "SELECT id, firstname, lastname, email, role FROM userinfos"; 
    $result = mysqli_query($conn, $sql);
    $users = [];
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $users[] = $row;
        }
    }
    return $users;
}


function getUserById($id){
    $conn = getConnection();
    $sql = "SELECT firstname, lastname, selfImage FROM userinfos WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) === 1){
        return mysqli_fetch_assoc($result);
    } else {
        return false;
    }
}

function getUserByEmail($email){
    $conn = getConnection();
    $sql = "SELECT id, firstname,lastname,selfImage,password,role FROM userinfos WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) === 1){
        return mysqli_fetch_assoc($result);
    } else {
        return false;
    }
}


function insertUser($user){
    $conn = getConnection();
    $checkEmail = "SELECT id FROM userinfos WHERE email = '{$user['email']}'";
    $result = mysqli_query($conn, $checkEmail);

    if(mysqli_num_rows($result) > 0){
        return false;
    }

    $sql = "INSERT INTO userinfos (
        firstname,
        lastname,
        email,
        password,
        phone,
        DOB,
        gender,
        address,
        selfImage,
        role
    ) VALUES (
        '{$user['firstname']}',
        '{$user['lastname']}',
        '{$user['email']}',
        '{$user['password']}',
        '{$user['phone']}',
        '{$user['DOB']}',
        '{$user['gender']}',
        '{$user['address']}',
        '{$user['selfImage']}',
        '{$user['role']}'
    )";

    if(mysqli_query($conn, $sql)){
        return true;
    } else {
        return false;
    }
}


function updateUser($user){
    $conn = getConnection();
    $sql = "UPDATE userinfos SET
        firstname = '{$user['firstname']}',
        lastname = '{$user['lastname']}',
        phone = '{$user['phone']}',
        DOB = '{$user['DOB']}',
        gender = '{$user['gender']}',
        address = '{$user['address']}'
    WHERE email = '{$user['email']}'";

    if(mysqli_query($conn, $sql)){
        return true;
    } else {
        return false;
    }
}

function updateAvatar($user){
    $conn = getConnection();
    $sql = "UPDATE userinfos SET selfImage = '{$user['selfImage']}' WHERE email = '{$user['email']}'";

    if(mysqli_query($conn, $sql)){
        return true;
    } else {
        return false;
    }
}
function getUserRoleById($id){
    $conn = getConnection();
    $sql = "SELECT role FROM userinfos WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) === 1){
        $row = mysqli_fetch_assoc($result);
        return $row['role'];
    } else {
        return false;
    }
}

function updateUserRoleInDB($userId, $newRole){
    $conn = getConnection();
    $userId = mysqli_real_escape_string($conn, $userId);
    $newRole = mysqli_real_escape_string($conn, $newRole);
    $sql = "UPDATE userinfos SET role = '$newRole' WHERE id = '$userId'";

    if(mysqli_query($conn, $sql)){
        return true;
    } else {
        return false;
    }
}


function updatePassword($user){
    $conn = getConnection();
    $sql = "UPDATE userinfos SET password = '{$user['password']}' WHERE email = '{$user['email']}'";

    if(mysqli_query($conn, $sql)){
        return true;
    } else {
        return false;
    }
}

function updateUserRole($userId, $newRole){
    $conn = getConnection();
    $sql = "UPDATE userinfos SET role = ? WHERE ID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "si", $newRole, $userId);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } else {
        $result = false;
    }
    mysqli_close($conn);
    return $result;
}

function deleteUser($userId){
    $conn = getConnection();
    $sql = "DELETE FROM userinfos WHERE ID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $userId);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } else {
        $result = false;
    }
    mysqli_close($conn);
    return $result;
}
?>