<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require 'config/constants.php';

$username_email = $_SESSION['signin-data']['username_email']??null;
$password = $_SESSION['signin-data']['password']??null;

unset($_SESSION['signin-data']);
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
			<h2>Sign In</h2>
			<?php if (isset($_SESSION['signin-success'])) : ?>
			<div class="alert_message success">
				<p>
					<?= $_SESSION['signin-success'];
					unset($_SESSION['signin-success']);
				?>
					
				</p>
			</div>
		<?php elseif (isset($_SESSION['signin'])) : ?>
		<div class="alert_message error">
				<p>
					<?= $_SESSION['signin'];
					unset($_SESSION['signin']);
				?>
					
				</p>
			</div>
		<?php endif ?>
			<form action="<?= ROOT_URL ?>signin-logic.php" method="POST" enctype="multipart/form-data">
				<input type="text" name="username_email" value="<?= $username_email ?>" placeholder="Username or Email">
				<input type="password" name="password" value="<?= $password ?>" placeholder="Password">
				<button type="submit" name="submit" class="btn">Sign In</button>
				<small>Don't have account?<a href="signup.php">Sign Up</a></small>
				
			</form>
		</div>
	</section>
</body>
</html>