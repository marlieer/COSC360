<?php include '../top.php'; ?>
<form name="edituserform"  method="post" action="http://randyconnolly.com/tests/process.php" onsubmit="return validateUserUpdate()">
	<fieldset>
	<legend>Edit User</legend>
		<p>
			<label>First Name</label>
			<input class="form-control" type="text" name="fname" id="fname" value="Khoi"/>
		</p>
		<p>
			<label>Last Name</label>
			<input class="form-control" type="text" name="lname" id="lname" value="Ngo"/>
		</p>
		<p>
			<label>Birthday</label>
			<input class="form-control" type="date" name="birth" id="birth" value="1997-01-01"/>
		</p>
		<p>
			<label>Email</label>
			<input class="form-control" type="text" name="email" id="email" value="test123@gmail.com"/>
        </p>
        <p>
            Password must include: <br>
            1 lowercase, 1 uppercase, 1 number, and at least 8 characters
        </p>
		<p>
			<label> Old Password</label>
			<input class="form-control" type="password" name="oldpass" id="oldpass" value="1234Abcd"/>
        </p>
        <p>
			<label>New Password</label>
			<input class="form-control" type="password" name="newpass" id="newpass"/>
		</p>
		<p>
			<label>Re-enter New Password</label>
			<input class="form-control" type="password" name="rpass" id="rpass"/>
        </p>
        <br/>
		<button class="btn my-btn" type="submit">Save</button>
	</fieldset>
</form>
<?php include '../bottom.php'; ?>