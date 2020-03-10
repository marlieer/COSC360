<?php include '../top.php'; ?>
<form name="signupform"  method="post" action="../server/auth.php" onsubmit="return validateNewUser()">
	<fieldset>
	<legend>New User</legend>
		<p>
			<label for="fname">First Name</label>
			<input class="form-control" type="text" name="fname" id="fname" />
		</p>
		<p>
			<label for="lname">Last Name</label>
			<input class="form-control" type="text" name="lname" id="lname" />
		</p>
		<p>
			<label for="birth">Birthday</label>
			<input class="form-control" type="date" name="birth" id="birth"/>
		</p>
		<p>
			<label for="email">Email</label>
			<input class="form-control" type="email" name="email" id="email"/>
        </p>
        <p>
            Password must include: <br>
            <small>1 lowercase, 1 uppercase, 1 number, and at least 8 characters</small>
        </p>
		<p>
			<label for="pass">Password</label>
			<input class="form-control" type="password" name="pass" id="pass" />
		</p>
		<p>
			<label for="rpass">Re-enter Password</label>
			<input class="form-control" type="password" name="rpass" id="rpass" />
        </p>
        <br/>
		<button type="submit" class="btn my-btn" name="signup-submit">Signup</button>
		<a href="login.php">Have an account?</a>
	</fieldset>
</form>
<?php include '../bottom.php'; ?>