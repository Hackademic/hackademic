{include file="_header.tpl"}

<div class="main_content">
    <div class="header_bar">
	<div class="page_title"><h3 class="left">{t}Edit User{/t}</h3></div>
    </div><br/>
    <div id="usermessage">{include file="_usermessage.tpl"}</div>
    
    <div id="input_form">
    <form id="form" name="form" method="post">
	<table class="user_add">
	    <tr>
		<td><label for="name">{t}Username{/t}</label></td>
		<td><input type="text" name="username" value="{$user->username}" readonly="readonly"/></td>
	    </tr>
	    
	    <tr>
		<td><label>{t}Full Name{/t}</label></td>
		<td><input type="text" name="full_name" value="{$user->full_name}"/></td>
	    </tr>
	    
	    <tr>
		<td><label>{t}Email{/t}</label></td>
		<td><input type="text" name="email" id="email" value="{$user->email}"/></td>
	    </tr>
	    
	    <tr>
		<td><label>{t}Password{/t}</label></td>
		<td><input type="password" name="password" id="password"/></td>
	    </tr>
		    
	    <tr>
		<td><label>{t}Activate User{/t}</label></td>
		<td class="radio">
		    {if $user->is_activated}
			<input type="radio" name="is_activated" value="1" checked="true" />{t}Yes{/t}
			<input type="radio" name="is_activated" value="0" />{t}No{/t}
		    {else}
			<input type="radio" name="is_activated" value="1"  />{t}Yes{/t}
			<input type="radio" name="is_activated" value="0" checked="true" />{t}No{/t}
		    {/if}
		</td>
	    </tr>
	    
		<tr>
		<td><label>{t}Select the type of user{/t}</label></td>
		<td><select name="type">
			    {if $user->type==0}
               <option value="0" selected="selected">{t}Student{/t}</option>
			   <option value="1" >{t}Admin{/t}</option>
			   <option value="2" >{t}Teacher{/t}</option>
			   {elseif $user->type==2}
               <option value="2" selected="selected">{t}Teacher{/t}</option>
			   <option value="1" >{t}Admin{/t}</option>
			   <option value="0" >{t}Student{/t}</option>
			   {else}
               <option value="1" selected="selected">{t}Admin{/t}</option>
			   <option value="2" >{t}Teacher{/t}</option>
			   <option value="0" >{t}Student{/t}</option>
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