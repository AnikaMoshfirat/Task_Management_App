<?php
session_start();
require_once('../model/db.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conn = getConnection();
    if (!$conn) {
        die("Database connection failed!");
    }

    $first = mysqli_real_escape_string($conn, $_POST['firstname']);
    $last = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $dob = mysqli_real_escape_string($conn,$_POST['dob']);
    $gender = mysqli_real_escape_string($conn,$_POST['gender']);
    $address = mysqli_real_escape_string($conn,$_POST['address']);

    $hashedPassword = password_hash($password,PASSWORD_DEFAULT);

    if (isset($_FILES["profile_image"]) && $_FILES["profile_image"]["error"] === UPLOAD_ERR_OK) {
        $targetDir = "../asset/upload/profilePic/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = time() . "_" . basename($_FILES["profile_image"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
        $allowed = ["jpg", "jpeg", "png"];

        if (in_array($imageFileType, $allowed)) {
            if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $targetFilePath)) {
                $imagePath = "asset/upload/profilePic/" . $fileName;

                $stmt = $conn->prepare("INSERT INTO userinfos (firstname, lastname, email, password, phone, dob, gender, address, selfImage, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'User')");
                $stmt->bind_param("sssssssss", $first, $last, $email, $hashedPassword, $phone, $dob, $gender, $address, $imagePath);

                if ($stmt->execute()) {
                    $_SESSION['success'] = "Registration successful. Please log in.";
                    header("Location: ../view/php/loginPage.php");
                    exit;
                } else {
                    echo "Database error: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "<script>alert('Image upload failed.');</script>";
            }
        } else {
            echo "<script>alert('Invalid image type. Only JPG, PNG & JPEG allowed!');</script>";
        }
    } else {
        echo "<script>alert('No image selected or upload error!');</script>";
    }

    mysqli_close($conn);
}
?>
