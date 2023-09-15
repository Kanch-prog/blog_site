<?php
session_start();
include 'config/constants.php';
require 'config/database.php'; // Make sure this includes your database connection

if(isset($_POST['submit'])){
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $avatar = $_FILES['avatar'];

    if (!$firstname || !$lastname || !$username || !$email || !$createpassword || !$confirmpassword || !$avatar['name']) {
        $_SESSION['signup'] = "Please fill in all fields";
    } elseif (strlen($createpassword) < 8) {
        $_SESSION['signup'] = "Password should be 8+ characters";
    } elseif ($createpassword !== $confirmpassword) {
        $_SESSION['signup'] = "Passwords do not match";
    } else {
        $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);
        $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email'";
        $user_check_result = mysqli_query($connection, $user_check_query);

        if (mysqli_num_rows($user_check_result) > 0) {
            $_SESSION['signup'] = "Username or Email already exist";
        } else {
            $time = time();
            $avatar_name = $time . $avatar['name'];
            $avatar_tmp_name = $avatar['tmp_name'];
            $avatar_destination_path = 'images/' . $avatar_name;
            $allowed_files = ['png', 'jpg', 'jpeg'];
            $extension = pathinfo($avatar_name, PATHINFO_EXTENSION);

            if (in_array($extension, $allowed_files)) {
                if ($avatar['size'] < 1000000) {
                    if (move_uploaded_file($avatar_tmp_name, $avatar_destination_path)) {
                        $insert_user_query = "INSERT INTO users (firstname, lastname, username, email, password, avatar, is_admin) VALUES (?, ?, ?, ?, ?, ?, 0)";
                        $stmt = mysqli_prepare($connection, $insert_user_query);
                        mysqli_stmt_bind_param($stmt, "ssssss", $firstname, $lastname, $username, $email, $hashed_password, $avatar_name);

                        if (mysqli_stmt_execute($stmt)) {
                            $_SESSION['signup-success'] = "Registration successful";
                            header('location: ' . ROOT_URL . 'signin.php');
                            die();
                        } else {
                            $_SESSION['signup'] = "Error inserting user into database";
                        }
                    } else {
                        $_SESSION['signup'] = "Error uploading avatar";
                    }
                } else {
                    $_SESSION['signup'] = "File size too big. Should be less than 1MB";
                }
            } else {
                $_SESSION['signup'] = "File should be png, jpg, or jpeg";
            }
        }
    }

    if (isset($_SESSION['signup'])) {
        $_SESSION['signup-data'] = $_POST;
        header('location: ' . ROOT_URL . 'signup.php');
        die();
    }
} else {
    header('location: ' . ROOT_URL . 'signup.php');
    die();
}
?>
