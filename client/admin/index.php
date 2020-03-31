<?php include '../top.php'; ?>
<?php include 'admin_check.php'; ?>
<?php include '../../server/admin.php'; ?>
<style>
h3{
	margin-top: 1em;
	text-align: center;
}
table {
	margin-left: auto;
	margin-right: auto;
	width: 90%;
}
tr:hover {
	background-color: #b0e6eb;
}

</style>
<main class="container">
	<div class="content">
		<h3>Registered Users</h3>
		<section id="search_user" style="display:block; text-align:center; margin-top:2em; margin-bottom: 2em;">
			<form action="../server/admin.php" method="post">
			<select name ="search_type" id="search_type">
				<option value="">Select Type</option>
				<option value="name">Name</option>
				<option value="email">Email</option>
				<option value="post">Post Title</option>
			</select>
			<input type="text" name="search_text" id="search_text" placeholder="Search"/>
			<input type="submit" name="search_button" id="search_button">
		</section>
		<section id="users">
			<table>
				<thead>
					<tr>
						<th>Enable/Disable</th>
						<th>Delete</th>
						<th>Users</th>
					</tr>
				</thead>
				<tbody>
				<?php if(isset($_GET['type']) && isset($_GET['search']))
						show_users_by($_GET['type'], $_GET['search']);
						else
						show_all_users();	
				?>
				</tbody>
			</table>
		</section>
	</div>
</main>
<?php include '../bottom.php'; ?>