<?php include '../top.php'; ?>
<form name="forgotpassform" method="post" action="../server/auth.php" onsubmit="return forgotPassword()">
	<fieldset>
	<legend>Forgot Password</legend>
		<p>
			Please enter your email. An email will  be sent to reset your password. 
		</p>
		<p>
			<label>Email</label>
			<input class="form-control" type="text" name="email"/>
        </p>
        <br/>
		<button type="submit" class="btn my-btn" name="forgot-submit">Submit</button>
		<a href="login.php">Go Back</a>
	</fieldset>
</form>
<?php include '../top.php'; ?>