{include file="_header.tpl"}

<div class="main_content">
    <div class="header_bar">
	<div class="page_title"><h3 class="left">Add User</h3></div>
    </div><br/>
    <div id="usermessage">{include file="_usermessage.tpl"}</div>
    
    <div id="input_form">
    <form id="form" name="form" method="post">
	<table class="user_add">
	    <tr>
		<td><label for="name">Username</label></td>
		<td><input type="text" name="username"/></td>
	    </tr>
	    
	    <tr>
		<td><label>Full Name</label></td>
		<td><input type="text" name="full_name"/></td>
	    </tr>
	    
	    <tr>
		<td><label>Email</label></td>
		<td><input type="text" name="email" id="email"/></td>
	    </tr>
	    
	    <tr>
		<td><label>Password</label></td>
		<td><input type="password" name="password" id="password"/></td>
	    </tr>
	    
	    <tr>
		<td><label>Confirm Password</label></td>
		<td><input type="password" name="confirmpassword" id="password"/></td>
	    </tr>
	    
	    <tr>
		<td><label>Activate User</label></td>
		<td class="radio">
		    <input type="radio" name="is_activated" value="1"/>Yes
		    <input type="radio" name="is_activated" value="0"/>No
		</td>
	    </tr>
		
		<tr>
		<td><label>Select the type of user</label></td>
		<td><select name="type">
		       <option value="">Select</option>
               <option value="0">Student</option>
               <option value="2">Teacher</option>
               <option value="1">Admin</option>
        </select></td>
		</tr>
	    
	    <tr class="submit_btn">
		<td colspan="2">
		    <p class="submit"><input type="submit" name="submit" id="submit" value="Add User" /></p>
		</td>
	    </tr>
	</table>
    </form>
    </div>
</div>
{include file="_footer.tpl"}