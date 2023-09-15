<?php
session_start();
include 'config/constants.php';

$firstname = $_SESSION['signup-data']['firstname'] ?? null;
$lastname = $_SESSION['signup-data']['lastname']?? null;
$username = $_SESSION['signup-data']['username']?? null;
$email = $_SESSION['signup-data']['email']?? null;
$createpassword = $_SESSION['signup-data']['createpassword']?? null;
$confirmpassword = $_SESSION['signup-data']['confirmpassword']?? null;
unset($_SESSION['sign-up']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,intial-scale=1.0">
	<title>My Blog</title>
	<!--CUSTOM STYLESHEET-->
	<link rel="stylesheet" href="./css/style.css">
	<!--ICONSCOUT CDN-->
	<link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!--GOOGLE FONT-->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css2?famil=Montserrat:wght@300;400;500;600;700;800;900&display=swap">
</head>
<body>
	<section class="form_section">
		<div class="container form_section-contatiner">
			<h2>Sign Up</h2>
			<?php if(isset($_SESSION['signup'])) : ?>
				<div class="alert_message error">
					<p>
						<?= $_SESSION['signup'];
						unset($_SESSION['signup']);
						?>
					</p>				
					
				</div>
			<?php endif ?>
			<form action="<?= ROOT_URL ?>signup-logic.php" enctype="multipart/form-data" method="POST">
				<input type="text" name="firstname" value="<?= $firstname ?>" placeholder="First Name">
				<input type="text" name="lastname" value="<?= $lastname ?>" placeholder="Last Name">
				<input type="text" name="username" value="<?= $username ?>" placeholder="Username">
				<input type="email" name="email" value="<?= $email ?>" placeholder="Email">
				<input type="password" name="createpassword" value="<?= $createpassword ?>" placeholder="Create Password">
				<input type="password" name="confirmpassword" value="<?= $confirmpassword ?>" placeholder="Confirm Password">
				<div class="form_control">
					<label for="avatar">User Avatar</label>
					<input type="file" name='avatar' id="avatar">					
				</div>
				<button type="submit" name="submit" class="btn">Sign Up</button>
				<small>Already have an account?<a href="signin.php">Sign In</a></small>
				
			</form>
		</div>
	</section>
<?php
include 'partials/footer.php'
?>