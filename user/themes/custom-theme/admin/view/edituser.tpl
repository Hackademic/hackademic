{include file="_header.tpl"}

<div class="main_content">
    <div class="header_bar">
	<div class="page_title"><h3 class="left">Edit User</h3></div>
    </div><br/>
    <div id="usermessage">{include file="_usermessage.tpl"}</div>
    
    <div id="input_form">
    <form id="form" name="form" method="post">
	<table class="user_add">
	    <tr>
		<td><label for="name">Username</label></td>
		<td><input type="text" name="username" value="{$user->username}" readonly="readonly"/></td>
	    </tr>
	    
	    <tr>
		<td><label>Full Name</label></td>
		<td><input type="text" name="full_name" value="{$user->full_name}"/></td>
	    </tr>
	    
	    <tr>
		<td><label>Email</label></td>
		<td><input type="text" name="email" id="email" value="{$user->email}"/></td>
	    </tr>
	    
	    <tr>
		<td><label>Password</label></td>
		<td><input type="password" name="password" id="password"/></td>
	    </tr>
		    
	    <tr>
		<td><label>Activate User</label></td>
		<td class="radio">
		    {if $user->is_activated}
			<input type="radio" name="is_activated" value="1" checked="true" />Yes
			<input type="radio" name="is_activated" value="0" />No
		    {else}
			<input type="radio" name="is_activated" value="1"  />Yes
			<input type="radio" name="is_activated" value="0" checked="true" />No
		    {/if}
		</td>
	    </tr>
	    
		<tr>
		<td><label>Select the type of user</label></td>
		<td><select name="type">
			    {if $user->type==0}
               <option value="0" selected="selected">Student</option>
			   <option value="1" >Admin</option>
			   <option value="2" >Teacher</option>
			   {elseif $user->type==2}
               <option value="2" selected="selected">Teacher</option>
			   <option value="1" >Admin</option>
			   <option value="0" >Student</option>
			   {else}
               <option value="1" selected="selected">Admin</option>
			   <option value="2" >Teacher</option>
			   <option value="0" >Student</option>
			   {/if}
			   
        </select></td>
		</tr>
	    
	    <tr class="submit_btn">
		<td colspan="2">
		    <p class="submit">
			<input type="submit" name="submit" id="submit" value="Edit User" />
			<input type="submit" name="deletesubmit" id="deletesubmit" value="Delete User" />
		    </p>
		</td>
	    </tr>
	</table>
    </form>
    </div>
</div>
{include file="_footer.tpl"}