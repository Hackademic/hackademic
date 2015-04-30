{t}HELLO_WORLD{/t}
<div id="login">
    <form class="login" method="post" action="{$site_root_path}?url=login">
	<fieldset id="inputs">
	    <legend>{t}Login Details{/t}</legend>
	    <label>{t}Username{/t}</label>
	    <input name="username" type="text" autofocus required>
	    <label>{t}Password{/t}</label>
	    <input name="pwd" id="password" type="password" required>
	    <input class="submit" name="submit" type="submit" id="submit" value="Login"><br/>
	    <a href="{$site_root_path}?url=forgotpassword">{t}Forgot your password{/t}</a><br/>
	    <a href="{$site_root_path}?url=register">{t}Create an account{/t}</a>
        </fieldset>
    </form>
</div>
        