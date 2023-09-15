<?php

require 'config/database.php';

if(isset($_POST['submit'])){
	$id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
	$previous_thumbnail_name = filter_var($_POST['previous_thumbnail_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$body = filter_var($_POST['body'], FILTER_VALIDATE_EMAIL);
	$category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
	$is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
	$avatar = $_FILES['thumbnail'];
	//var_dump('avatar');
	//echo $firstname, $lastname, $username, $email, $createpassword, $confirmpassword;
	
    if (!$title || !$body || !$category_id || !$thumbnail['name']) {
        $_SESSION['edit-post'] = "Please fill in all required fields.";
    } else {
        $time = time();
        $thumbnail_name = $time . $thumbnail['name'];
        $thumbnail_tmp_name = $thumbnail['tmp_name'];
        $thumbnail_destination_path = '../images/' . $thumbnail_name;

        $allowed_files = ['png', 'jpg', 'jpeg'];
        $extension = pathinfo($thumbnail_name, PATHINFO_EXTENSION);

        if (in_array($extension, $allowed_files)) {
            if ($thumbnail['size'] < 2_000_000) {
                move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);

            }else{
                $_SESSION['edit-post'] = "File size too big";
            }
        }else{
            $_SESSION['edit-post'] = "files should be png, jpg or jpeg";
        }
    }
    if(isset($_SESSION['edit-post'] )){
        $_SESSION['edit-post-data'] = $_POST;
        header('location: ' . ROOT_URL . 'admin/edit-post.php');
	die();
    }else{
        if($is_featured == 1){
            $zero_all_is_featured_query = "UPDATE posts SET is_featured = 0";
            $zero_all_is_featured_result = mysqli_query($connection, $zero_all_is_featured_query);
        }
$thumbnail_to_insert = $thumbnail_name ?? $previous_thumbnail_name;

        $query = "UPDATE posts SET title='$title',body='$body', thumbnail='$thumbnail_to_insert',category_id='$category_id',is_featured='$is_featured' WHERE id=$id LIMIT 1";

        $result = mysqli_query($connection, $query);

        if(!mysqli_errno($connection)){
            $_SESSION['edit-post-success'] = "Post updated";
            header('location: ' . ROOT_URL . 'admin/');
            die();
        }
    }
    
    header('location: ' . ROOT_URL . 'admin/');
	die();
}
?>