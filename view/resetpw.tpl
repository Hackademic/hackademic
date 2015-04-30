{include file="_header_frontend.tpl"}
<div class="main_content">
    <div class="header_bar">
	<div class="page_title"><h3 class="left">{t}Reset Your Password?{/t}</h3></div>
    </div><br/><br/>
    
    <div id="input_form">
    <form id="form" name="form" method="post">
	<table class="user_add" style="height: auto;">
	    <tr>
		<td><label for="name">{t}Enter New Password:{/t}</label></td>
		<td><input type="password" name="newpassword"/></td>
		<td><br/><br/><br/><br/></td>
	    </tr>
		<tr>
		<td><label for="name">{t}Confirm Password:{/t}</label></td>
		<td><input type="password" name="confirmnewpassword"/></td>
	    </tr>
	    <tr class="submit_btn">
		<td colspan="2">
		    <p class="submit"><input type="submit" name="submit" id="submit" value="Submit Password" /></p>
		</td>
	    </tr>
	</table>
    </form>
    </div>
</div>
{include file="_footer_frontend.tpl"}