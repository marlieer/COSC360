<?php include '../top.php'; ?>
<?php include 'user_check.php'; ?>
<?php include '../../server/users.php'; ?>
<?php $data = show_users($_SESSION["id"]); $name=explode(" ", $data[1]);?>
<form name="edituserform" enctype="multipart/form-data" method="post" action="../server/users.php" onsubmit="return validateUserUpdate()">
	<fieldset>
	<legend>Edit User</legend>
		<p>
			<label>Profile Picture</label><br>
			<input type="file" name="upload" id="upload">
			Current Profile Picture:<?php if(!empty($data[4])) echo '<img src="'.$data[4].'" alt="'.$data[1].'" style="height: 100px; width: 150px;"/>'; ?>
		</p>
		<p>
			<label>First Name</label>
			<input class="input form-control" type="text" name="fname" id="fname" value="<?php echo $name[0]; ?>"/>
		</p>
		<p>
			<label>Last Name</label>
			<input class="input form-control" type="text" name="lname" id="lname" value="<?php echo $name[1]; ?>"/>
		</p>
		<p>
			<label>Birthday</label>
			<input class="input form-control" type="date" name="birth" id="birth" value="<?php echo $data[2]; ?>"/>
		</p>
		<p>
			<label>Email</label>
			<input class="input form-control" type="text" name="email" id="email" value="<?php echo $data[3]; ?>"/>
        </p>
        <p>
            <small>
            Password must include: <br>
            1 lowercase, 1 uppercase, 1 number, and at least 8 characters
            </small>
        </p>
		<p>
			<label> Old Password</label>
			<input class="input form-control" type="password" name="oldpass" id="oldpass" />
        </p>
        <p>
			<label>New Password</label>
			<input class="input form-control" type="password" name="newpass" id="newpass"/>
		</p>
		<p>
			<label>Re-enter New Password</label>
			<input class="input form-control" type="password" name="rpass" id="rpass"/>
        </p>
        <br/>
		<button class="btn my-btn" type="submit" name="edit-submit">Save</button>
	</fieldset>
</form>
<?php include '../bottom.php'; ?>