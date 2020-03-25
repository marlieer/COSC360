<?php include '../top.php'; ?>
    <main>
        <div class="container">
            <form name="loginform" method="post" action="../server/auth.php" onsubmit="return validateUser()">
                <fieldset>
                    <legend>Login</legend>
                    <p>
                        <label>Email</label>
                        <input class="input form-control" type="text" name="email" id="email"/>
                    </p>
                    <p>
                        <label>Password</label>
                        <input class="input form-control" type="password" name="pass" id="pass"/>
                    </p>
                    <br/>                   
                    <button type="submit" class="btn my-btn" name="login-submit">Login</button>
                    <a href="auth/signup.php">Sign Up</a>
                    <a href="auth/forgotpassword.php">Forgot Password?</a>
                </fieldset>
            </form>
        </div>
    </main>
<?php include '../bottom.php'; ?>