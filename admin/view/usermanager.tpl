{include file="_header.tpl"}
<link rel="stylesheet" type="text/css" href="{$site_root_path}assets/css/pagination.css"/>

<div class="main_content">
    <div class="header_bar">
	<div class="page_title"><h3 class="left">{t}User Manager{/t}</h3></div>
	<div id="" class="right action_button">
	    
	    <table>
		<tr class="center">
		    <td>
			<div class="submenu_btn">
			    <a href="{$site_root_path}?url=admin/adduser">
				<img class="action_image" src="{$site_root_path}admin/assets/images/adduser.png"/><br/>
				<span class="caption">{t}Add User{/t}</span>
			    </a>
			</div>
		    </td>
		    <td>
			<div class="submenu_btn">
			    <a href="{$site_root_path}?url=admin/addclass">
				<img class="action_image" src="{$site_root_path}admin/assets/images/addclass.png"/><br/>
				<span class="caption">{t}Add Class{/t}</span>
			    </a>
			</div>
		    </td>
		    <td>
			<div class="submenu_btn">
			    <a href="{$site_root_path}?url=admin/manageclass">
				<img class="action_image" src="{$site_root_path}admin/assets/images/manageclass.png"/><br/>
				<span class="caption">{t}Class Manager{/t}</span>
			    </a>
			</div>
		    </td>
		</tr>
	    </table>
	</div>
    </div><br/>
    
    <div id="input_form">
	<form method ="get">
    <input type="hidden" name="url" value="{$smarty.get.url}">
	    <table class="add_form center">
		<tr>
		    <td class="width_40">Search:  <input class="width_90" type="text" name="search" id="search" placeholder="Search Text"/></td>
			<td class="width_10">{t}Sort By:{/t}</td>
		    <td class="width_25">
			<select name="category" class="width_90">
			    <option value="username">{t}Username{/t}</option> 
			    <option value="full_name">{t}Full Name{/t}</option> 
			    <option value="email">{t}Email{/t}</option> 
			</select>
		    </td>
			<td >{t}Show:{/t}</td>
			<td class="width_25">
			  <select name="limit" class="width_90">
	             <option value="">{t}Results Per Page{/t}</option>
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
	    <th align = "left"> {t}Username{/t}</th>
	    <th align = "left">{t}Full Name{/t}</th>
	    <th align = "left">{t}Email{/t}</th>
	    <th align = "left">{t}Classes{/t}</th>
	    <th align = "left">{t}Joined{/t}</th>
	    <th align = "left">{t}Last Visit{/t}</th>
	    <th align = "left">{t}Activated{/t}</th>
	    <th align = "left">{t}Type Of User{/t}</th>
	</thead>
	{foreach from=$users item=user}
	    <tr>
		<td><a href="{$site_root_path}?url=admin/edituser&id={$user->id}">{$user->username}</a></td>
		<td>{$user->full_name}</td>
		<td>{$user->email}</td>
		<td>
		    <a href="{$site_root_path}?url=admin/classmemberships&id={$user->id}">{t}Edit{/t}</a>
		</td>
		<td>{$user->joined|date_format}</td>
		<td>{if $user->last_visit}{$user->last_visit|date_format}{else}{t}Never{/t}{/if}</td>
		<td>{if $user->is_activated}{t}Yes{/t}{else}{t}No{/t}{/if}</td>
		<td>{if $user->type==1}{t}Admin{/t}{elseif $user->type==2}{t}Teacher{/t}{else}{t}Student{/t}{/if}</td>
	   </tr>
	{/foreach}
    </table>
</div>
{include file="_footer.tpl"}
