{include file="_header_frontend.tpl"}

<div class="main_content">
    <div class="header_bar">
	<div class="page_title"><h3 class="left">{t}Register User{/t}</h3></div>
    </div><br/>
    
    <div id="input_form">
    <form id="form" name="form" method="post">
	<table class="user_add">
	    <tr>
		<td><label for="name">{t}Username{/t}</label></td>
		<td><input type="text" name="username" value="{$cached->username}"/></td>
	    </tr>
	    
	    <tr>
		<td><label>{t}Full Name{/t}</label></td>
		<td><input type="text" name="full_name" value="{$cached->name}"/></td>
	    </tr>
	    
	    <tr>
		<td><label>{t}Email{/t}</label></td>
		<td><input type="text" name="email" id="email" value="{$cached->email}"/></td>
	    </tr>
	    
	    <tr>
		<td><label>{t}Password{/t}</label></td>
		<td><input type="password" name="password" id="password"/></td>
	    </tr>
	    
	    <tr>
		<td><label>{t}Confirm Password{/t}</label></td>
		<td><input type="password" name="confirmpassword" id="password"/></td>
	    </tr>
	    
	    <tr class="submit_btn">
		<td colspan="2">
		    <p class="submit"><input type="submit" name="submit" id="submit" value="Register User" /></p>
		</td>
	    </tr>
	</table>
    </form>
    </div>
</div>
{include file="_footer_frontend.tpl"}
