<div id="login">
    <form class="login" method="post" action="{$site_root_path}pages/login.php">
	<fieldset id="inputs">
	    <legend>Login Details</legend>
	    <label>Username</label>
	    <input name="username" type="text" autofocus required>
	    <label>Password</label>
	    <input name="pwd" id="password" type="password" required>
	    <input class="submit" name="submit" type="submit" id="submit" value="Login"><br/>
	    <a href="{$site_root_path}pages/forgotpassword.php">Forgot your password</a><br/>
	    <a href="{$site_root_path}pages/register.php">Create an account</a>
        </fieldset>
    </form>
</div>