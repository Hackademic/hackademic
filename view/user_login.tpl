<div id="login">
    <form class="login" method="post" action="{$site_root_path}?url=login">
	<fieldset id="inputs">
	    <legend> Login Details </legend>
	    <label> Username </label>
	    <input name="username" type="text" autofocus required>
	    <label> Password </label>
	    <input name="pwd" id="password" type="password" required>
	    <br><br>
	    <div class="g-recaptcha" data-sitekey="{$smarty.const.G_SITE_KEY}"></div>
	    <input class="submit" name="submit" type="submit" id="submit" value="Login"><br/>
	    <a href="{$site_root_path}?url=forgotpassword"> Forgot your password </a><br/>
	    <a href="{$site_root_path}?url=register"> Create an account </a>
    </fieldset>
    </form>
</div>
<script src='https://www.google.com/recaptcha/api.js'></script>