{include file="_header.tpl"}
<link rel="stylesheet" type="text/css" href="{$site_root_path}assets/css/pagination.css"/>

<div class="main_content">
    <div class="header_bar">
	<div class="page_title"><h3 class="left">User Manager</h3></div>
	<div id="" class="right action_button">
	    
	    <table>
		<tr class="center">
		    <td>
			<div class="submenu_btn">
			    <a href="{$site_root_path}admin/pages/adduser.php">
				<img class="action_image" src="{$site_root_path}admin/assets/images/adduser.png"/><br/>
				<span class="caption">Add User</span>
			    </a>
			</div>
		    </td>
		    <td>
			<div class="submenu_btn">
			    <a href="{$site_root_path}admin/pages/addclass.php">
				<img class="action_image" src="{$site_root_path}admin/assets/images/addclass.png"/><br/>
				<span class="caption">Add Class</span>
			    </a>
			</div>
		    </td>
		    <td>
			<div class="submenu_btn">
			    <a href="{$site_root_path}admin/pages/manageclass.php">
				<img class="action_image" src="{$site_root_path}admin/assets/images/manageclass.png"/><br/>
				<span class="caption">Class Manager</span>
			    </a>
			</div>
		    </td>
		</tr>
	    </table>
	</div>
    </div><br/>
    
    <div id="input_form">
	<form method ="get">
	    <table class="add_form center">
		<tr>
		    <td class="width_40">Search:  <input class="width_90" type="text" name="search" id="search" placeholder="Search Text"/></td>
			<td class="width_10">Sort By:</td>
		    <td class="width_25">
			<select name="category" class="width_90">
			    <option value="username">Username</option> 
			    <option value="full_name">Full Name</option> 
			    <option value="email">Email</option> 
			</select>
		    </td>
			<td >Show:</td>
			<td class="width_25">
			  <select name="limit" class="width_90">
	             <option value="">Results Per Page</option>
                 <option value="5">5</option>
				 <option value="10">10</option>
				 <option value="15">15</option>
				 <option value="20">20</option>
				 <option value="25">25</option>
				 <option value="30">30</option>
				 <option value="40">40</option>
				 <option value="50">50</option>
				 <option value="75">75</option>
				 <option value="100">100</option>
        	   </select>
		     </td>
		    <td class="submit_btn width_10">
			<p class="submit"><input type="submit" name="submit" id="submit" value="Submit" /></p>
		    </td>
		</tr>
	    </table>
	</form>
    </div>
    
    <div id="usermessage">{include file="_usermessage.tpl"}</div>
    <div id="paginate_div">{include file="_pagination.tpl"}</div>
    
    <table class="manager_table">
	<thead>
	    <th align = "left"> Username </th>
	    <th align = "left">Full Name</th>
	    <th align = "left">Email</th>
	    <th align = "left">Classes</th>
	    <th align = "left">Joined</th>
	    <th align = "left">Last Visit</th>
	    <th align = "left">Activated</th>
	    <th align = "left">Type Of User</th>
	</thead>
	{foreach from=$users item=user}
	    <tr>
		<td><a href="{$site_root_path}admin/pages/edituser.php?id={$user->id}">{$user->username}</a></td>
		<td>{$user->full_name}</td>
		<td>{$user->email}</td>
		<td>
		    <a href="{$site_root_path}admin/pages/classmemberships.php?id={$user->id}">Edit</a>
		</td>
		<td>{$user->joined|date_format}</td>
		<td>{if $user->last_visit}{$user->last_visit|date_format}{else}Never{/if}</td>
		<td>{if $user->is_activated}Yes{else}No{/if}</td>
		<td>{if $user->type==1}Admin{elseif $user->type==2}Teacher{else}Student{/if}</td>
	   </tr>
	{/foreach}
    </table>
</div>
{include file="_footer.tpl"}
