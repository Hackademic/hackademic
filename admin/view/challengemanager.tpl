{include file="_header.tpl"}
<link rel="stylesheet" type="text/css" href="{$site_root_path}assets/css/pagination.css"/>

<div class="main_content">
    <div class="header_bar">
	<div class="page_title"><h3 class="left">Challenge Manager</h3></div>
			<div id="" class="right action_button">
				<table>
				<tr class="center"><td></td></tr>
				<tr class="center">
				<td>
				<div class="submenu_btn">
    <a href="addchallenge.php?type=code">
    <span class="caption">Add Challenge</span></a></div></td></tr></table>
    </div></div><br/>
    <div id="input_form">
	<form method ="get">
	    <table class="add_form center">
		<tr><td>Search:</td>
		    <td class="width_40"> <input class="width_90" type="text" name="search" id="search"/></td>
			<td class="width_10">Order By:</td>
		    <td class="width_25">
			<select name="category" class="width_90">
			  <option value="title">Title</option>
			</select>
		    </td>
		    <td>Show:  </td>
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
			<p class="submit"><input type="submit" name="submit" id="submit" value="search" /></p>
		    </td>
		</tr>
		
	    </table>
	</form>
    </div>
    
    <div id="usermessage">{include file="_usermessage.tpl"}</div>
    <div id="paginate_div">{include file="_pagination.tpl"}</div>
    
    <table class="manager_table">
	<thead> 
	    <th align = "left">Challenge Title</th>
	    <th align = "left">Date posted</th>
	    <th align = "left">Visibility</th>
	    <th align = "left">Classes</th>
	    <th align = "left">Published</th>
	    <th align = "left">DELETE?</th>
	</thead>
	{foreach from=$challenges item=challenge}
	    <tr>
		<td>
		 <a href="{$site_root_path}admin/pages/editchallenge.php?id={$challenge->id}&action=update">
		 {$challenge->title}</a>
		</td>
		<td>{$challenge->date_posted|date_format}</td>
		<td>{if $challenge->visibility == "public"}Public{else}Private{/if}</td>
		<td>{if $challenge->visibility == "public"}N/A{else}<a href="{$site_root_path}admin/pages/classchallenges.php?id={$challenge->id}">Edit</a>{/if}</td>
		<td>{if $challenge->publish == 0}No{else}Yes{/if}</td>
		<td>   
		    <a href="{$site_root_path}admin/pages/challengemanager.php?id={$challenge->id}&action=del">Delete challenge?</a>
		</td>			
	    </tr>
	{/foreach}
    </table>
</div>
{include file="_footer.tpl"}
