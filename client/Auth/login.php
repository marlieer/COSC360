<?php include '../top.php'; ?>
<form name="loginform" method="post" action="http://randyconnolly.com/tests/process.php" onsubmit="return validateUser()">
	<fieldset>
	<legend>Login</legend>
		<p>
			<label>Email</label>
			<input class="form-control" type="text" name="email" id="email"/>
		</p>
		<p>
			<label>Password</label>
			<input class="form-control" type="password" name="pass" id="pass" />
        </p>
        <br/>
		<button  class="btn my-btn" type="submit">Login</button>
		<a href="signup.php">Sign Up</a>
		<a href="forgotpassword.php">Forgot Password?</a>
    </fieldset>
</form>
<?php include '../bottom.php'; ?>