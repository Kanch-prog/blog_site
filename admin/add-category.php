<?php
include 'partials/header.php'
?>

<body>
	<section class="form_section">
		<div class="container form_section-contatiner">
			<h2>Add Category</h2>
			
			<form action="<?= ROOT_URL ?>admin/add-category-logic.php" method="POST" enctype="multipart/form-data">
				<input type="text" name="title" placeholder="Title">
				<textarea rows="4"  name="description"  placeholder="Description"></textarea>
				<button type="submit"  name="submit" class="btn">Add Category</button>
			</form>
		</div>
	</section>
<?php
include 'partials/footer.php'
?>