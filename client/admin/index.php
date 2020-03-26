<?php include '../top.php'; ?>
<?php include 'admin_check.php'; ?>
<?php include '../../server/admin.php'; ?>
<main class="container">
	<div class="content">
		<section id="users">
        <h2>Registered Users</h2>
            <?php show_all_users(); ?>
		</section>
	</div>
</main>
<?php include '../bottom.php'; ?>