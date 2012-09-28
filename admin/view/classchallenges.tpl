{include file="_header.tpl"}
<link rel="stylesheet" type="text/css" href="{$site_root_path}assets/css/pagination.css"/>
<div class="main_content">
    <div class="header_bar">
	<div class="page_title"><h3 class="left">Class Membership - Challenges</h3></div>
    </div><br/>
    <div id="usermessage">{include file="_usermessage.tpl"}</div>
    
    <div id="input_form">
       <form method="post">
	    <table class="add_form">
	        <tr>
		    <td><label> Add challenge to class: </label></td>
		    <td>
			<select name="class_id">
			    {foreach from=$classes item=class}
				<option value="{$class->id}">{$class->name}</option>
			    {/foreach} 
			</select>
		    </td>
		    <td colspan="2">
			<p class="submit"><input type="submit" name="submit" id="submit" value="Add" /></p>
		    </td>
		</tr>
	    </table>
        </form>
    </div>
    <table class="manager_table">
	<thead> 
	    <th>Class name</th>
	    <th>Delete</th>
	</thead>
	{foreach from=$class_memberships item=class}
	    <tr>  
		<td><a href="{$site_root_path}admin/pages/showclass.php?id={$class['class_id']}">{$class['name']}</a></td>
		<td><a href="{$site_root_path}admin/pages/classchallenges.php?id={$smarty.get.id}&class_id={$class['class_id']}&action=del">Delete</a></td>
	    </tr>
	{/foreach} 			
    </table>
{include file="_footer.tpl"}