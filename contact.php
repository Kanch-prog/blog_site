<?php
include 'partials/header.php'
?>

	<section class="empty_page">
		<h1>Contact Us</h1>
	</section>
	
	<section class="form_section">
		<div class="container form_section-contatiner">
			<h2>Fill in the form to send us a message</h2>
						
			<form action="<?= ROOT_URL ?>contact-logic.php" method="POST" enctype="multipart/form-data">
				<input type="text" name="name" placeholder="name">
				<input type="email" name="email" placeholder="email">
				<textarea rows="10" name="body" placeholder="Body"></textarea>						
				
				<button type="submit" name="submit" class="btn">Submit</button>
			</form>
		</div>
	</section>
	
<?php
include 'partials/footer.php'
?>