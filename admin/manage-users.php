<?php

include 'partials/header.php';

$current_admin_id = isset($_SESSION['user-id']) ? $_SESSION['user-id'] : 0; // Set a default value if not set


$query = "SELECT * FROM users WHERE id <> $current_admin_id";

$users = mysqli_query($connection, $query);
?>
<section class="dashboard">
	<?php if(isset($_SESSION['add-user-success'])) : ?>
			<div class="alert_message success container">
				<p>
					<?= $_SESSION['add-user-success'];
					unset($_SESSION['add-user-success']);
				?>
					
				</p>
			</div>
        <?php endif ?>

	<div class="container dashboard_container">
		<button id="show_sidebar-btn" class="sidebar_toggle"><i class="uil uil-angle-right-b"></i></button>
		<button id="hide_sidebar-btn" class="sidebar_toggle"><i class="uil uil-angle-left-b"></i></button>
		
		
		<aside>
			<ul>
				<li><a href="add-post.php"><i class="uil uil-pen"></i><h5>Add Post</h5></a></li>
				<li><a href="dashboard.php"><i class="uil uil-postcard"></i><h5>Manage Post</h5></a></li>
				<?php if(isset($_SESSION['user_is_admin'])) : ?>
				<li><a href="add-user.php"><i class="uil uil-user-plus"></i><h5>Add User</h5></a></li>
				<li><a href="manage-users.php" class="active"><i class="uil uil-users-alt"></i><h5>Manage User</h5></a></li>
				<li><a href="add-category.php"><i class="uil uil-edit"></i><h5>Add Category</h5></a></li>
				<li><a href="manage-categories.php"><i class="uil uil-pen"></i><h5>Manage Categories</h5></a></li>
				<?php endif ?>				
			</ul>			
		</aside>
		<main>
			<h2>Manage Users</h2>
			<?php if(mysqli_num_rows($users) > 0) : ?>
			<table>
				<thead>
					<tr>
						<th>Name</th>
						<th>Username</th>
						<th>Edit</th>
						<th>Delete</th>
						<th>Admin</th>
					</tr>
				</thead>
				<tbody>
				<?php while ($user = mysqli_fetch_assoc($users)) : ?>
					<tr>
						<td><?= "{$user['firstname']} {$user['lastname']}" ?></td>
						<td><?= "{$user['username']}" ?></td>
						<td><a href="<?= ROOT_URL ?>admin/edit-user.php?id=<?= $user['id'] ?>" class="btn sm">Edit</a></td>
						<td><a href="<?= ROOT_URL ?>admin/delete-user.php?id=<?= $user['id'] ?>" class="btn danger">Delete</a></td>
						<td><?= $user['is_admin'] ? 'Yes' : 'No' ?></td>
					</tr>
				<?php endwhile ?>
				</tbody>
			</table>	
			<?php else : ?>
				<div class="alert__message error"><?= "No users found" ?></div>		
			<?php endif ?>
		</main>
	</div>
</section>
	<!--END OF DASHBOARD-->
<?php
include 'partials/footer.php';
?>