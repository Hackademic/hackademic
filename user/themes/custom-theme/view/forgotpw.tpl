{include file="_header_frontend.tpl"}
<div class="main_content">
    <div class="header_bar">
	<div class="page_title"><h3 class="left">Forgot Your Password?</h3></div>
    </div><br/><br/>
    
    <div id="input_form">
    <form id="form" name="form" method="post">
	<table class="user_add" style="height: auto;">
	    <tr>
		<td><label for="name">Enter Your Username:</label></td>
		<td><input type="text" name="username"/></td>
	    </tr>
	    <tr class="submit_btn">
		<td colspan="2">
		    <p class="submit left"><input type="submit" name="submit" id="submit" value="Submit Username" /></p>
		</td>
	    </tr>
	</table>
    </form>
    </div>
</div>
{include file="_footer_frontend.tpl"}