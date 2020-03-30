<?php include '../top.php'; ?>
<?php include 'admin_check.php'; ?>
<?php include '../../server/admin.php'; ?>
<main class="container">
	<div class="content">
		<section id="search_user">
			<form action="../server/admin.php" method="post">
			<select name ="search_type" id="search_type">
				<option value="">All</option>
				<option value="name">Name</option>
				<option value="email">Email</option>
				<option value="post">Post Title</option>
			</select>
			<input type="text" name="search_text" id="search_text" placeholder="Search"/>
            <input type="submit" name="search_button" id="search_button">
		</section>
		<section id="users">
        <h2>Registered Users</h2>
			<?php if(isset($_GET['type']) && isset($_GET['search']))
					show_users_by($_GET['type'], $_GET['search']);
					else
					show_all_users();	
			?>
		</section>
	</div>
</main>
<?php include '../bottom.php'; ?>