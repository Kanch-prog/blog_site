<?php
include 'partials/header.php';

$query = "SELECT * FROM categories";
$categories = mysqli_query($connection, $query);

?>

<body>
	<section class="form_section">
		<div class="container form_section-contatiner">
			<h2>Add Post</h2>
			
			<form action="<?= ROOT_URL ?>admin/add-post-logic.php" method="POST" enctype="multipart/form-data">
				<input type="text" name="title" placeholder="Title">
				<select name="category">
					<?php while($category = mysqli_fetch_assoc($categories)) : ?>
						<option value="<?= $category['id'] ?>"><?= $category['title'] ?></option>
					<?php endwhile ?>
				</select>
				<textarea rows="10" name="body" placeholder="Body"></textarea>

				<?php if(isset($_SESSION['user_is_admin'])) : ?>
				<div class="form_control inline">
					<input type="checkbox" name="is_featured" value="1" id="is_featured" checked>
					<label for="is_featured">Featured</label>				
				</div>
				<?php endif ?>
				<div class="form_control">
					<input type="file" name="thumbnail" id="thumbnail">
					<label for="thumbnail">Add Thumbnail</label>				
				</div>
				
				<button type="submit" name="submit" class="btn">Add Post</button>
			</form>
		</div>
	</section>
