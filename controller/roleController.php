<?php
require_once('../model/userModel.php');

header('Content-Type: application/json');

$response = ['success' => false, 'message' => 'Invalid request'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        switch ($action) {
            case 'updateRole':
                if (isset($_POST['userId']) && isset($_POST['newRole'])) {
                    $userId = $_POST['userId'];
                    $newRole = $_POST['newRole'];

                    if (updateUserRoleInDB($userId, $newRole)) {
                        $response = ['success' => true, 'message' => 'Role updated successfully!'];
                    } else {
                        $response = ['success' => false, 'message' => 'Failed to update role in database!'];
                    }
                } else {
                    $response['message'] = 'Missing userId/newRole for updateRole action';
                }
                break;
            case 'getAllUsers': 
                $users = getAllUsers();
                if ($users !== false) {
                    $response = ['success' => true, 'users' => $users];
                } else {
                    $response = ['success' => false, 'message' => 'Failed to retrieve users from database'];
                }
                break;
            default:
                $response['message'] = 'Unknown action';
                break;
        }
    }
}

echo json_encode($response);
?>