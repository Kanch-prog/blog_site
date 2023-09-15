<?php
require 'config/database.php';

if (isset($_POST['submit'])) {
    // Check if the 'user-id' key exists in the $_SESSION array
    if (!isset($_SESSION['user-id'])) {
        $_SESSION['add-post'] = "User session not found. Please log in again.";
        header('location: ' . ROOT_URL . 'admin/add-post.php');
        die();
    }

    $author_id = $_SESSION['user-id'];
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];
    $is_featured = $is_featured == 1 ? : 0;

    // Check for required fields
    if (!$title || !$category_id || !$body || !$thumbnail['name']) {
        $_SESSION['add-post'] = "Please fill in all required fields.";
        header('location: ' . ROOT_URL . 'admin/add-post.php');
        die();
    }

    // Check for file upload errors
    if ($thumbnail['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['add-post'] = "File upload error: " . $thumbnail['error'];
        header('location: ' . ROOT_URL . 'admin/add-post.php');
        die();
    }

    // Check file size and type
    $allowed_files = ['png', 'jpg', 'jpeg'];
    $extension = pathinfo($thumbnail['name'], PATHINFO_EXTENSION);
    if (!in_array($extension, $allowed_files)) {
        $_SESSION['add-post'] = "Files should be PNG, JPG, or JPEG.";
        header('location: ' . ROOT_URL . 'admin/add-post.php');
        die();
    }
    if ($thumbnail['size'] >= 2_000_000) {
        $_SESSION['add-post'] = "File size too big (max 2MB).";
        header('location: ' . ROOT_URL . 'admin/add-post.php');
        die();
    }

    // Move uploaded file to destination
    $time = time();
    $thumbnail_name = $time . $thumbnail['name'];
    $thumbnail_destination_path = '../images/' . $thumbnail_name;
    if (!move_uploaded_file($thumbnail['tmp_name'], $thumbnail_destination_path)) {
        $_SESSION['add-post'] = "Failed to move uploaded file.";
        header('location: ' . ROOT_URL . 'admin/add-post.php');
        die();
    }

    // Unset previous add-post data
    unset($_SESSION['add-post-data']);

    // Handle database insertion
    if ($is_featured == 1) {
        $zero_all_is_featured_query = "UPDATE posts SET is_featured = 0";
        $zero_all_is_featured_result = mysqli_query($connection, $zero_all_is_featured_query);
    }
    $query = "INSERT INTO posts (title, body, thumbnail, category_id, author_id, is_featured)
              VALUES ('$title', '$body', '$thumbnail_name', $category_id, $author_id, $is_featured)";
    $result = mysqli_query($connection, $query);

    if (!$result || mysqli_errno($connection)) {
        $_SESSION['add-post'] = "Database error: " . mysqli_error($connection);
        header('location: ' . ROOT_URL . 'admin/add-post.php');
        die();
    }

    $_SESSION['add-post-success'] = "New post added successfully.";
    header('location: ' . ROOT_URL . 'admin/');
    die();
}

header('location: ' . ROOT_URL . 'admin/add-post.php');
die();
?>
