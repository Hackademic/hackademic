{include file="_header.tpl"}
<link rel="stylesheet" type="text/css" href="{$site_root_path}assets/css/pagination.css"/>

<div class="main_content">
    <div class="header_bar">
	<div class="page_title"><h3 class="left">{t}Class Manager{/t}</h3></div>
	<div id="" class="right action_button">
	    
	<table>
		<tr class="center">
		    <td>
			<div class="submenu_btn">
			    <a href="{$site_root_path}?url=admin/addclass">
				<img class="action_image" src="{$site_root_path}admin/assets/images/addclass.png"/><br/>
				<span class="caption">{t}Add Class{/t}</span>
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
		    <td class="width_40">Search: <input placeholder="Class name to search" class="width_90" type="text" name="search" id="search" value="{if isset($search_string)}{$search_string}{/if}"/></td>
			<td class="width_10">Sort By:</td>
		    <td class="width_25">
			 <select name="category" class="width_90">
			    <option value="name">{t}Class Name{/t}</option> 
			</select>
		    </td>
		    <td class="width_10">{t}Show:{/t}</td>
		    <td class="width_25">
		     	<select name="limit" class="width_90">
	               <option value="">{t}Results per Page{/t}</option>
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
			<p class="submit"><input type="submit" name="submit" id="submit" value="Search" /></p>
		    </td>
		</tr>
	    </table>
	</form>
    </div>
    
    <div id="usermessage">{include file="_usermessage.tpl"}</div>
    <div id="paginate_div">{include file="_pagination.tpl"}</div>
    
    <table class="manager_table">
	<thead> 
	    <th align = "left">{t}Class name{/t}</th>
	    <th align = "left">{t}Date created{/t}</th>
	    <th align = "left">{t}Archive?{/t}</th>
	    <th align = "left">{t}Delete?{/t}</th>
	</thead>
	{foreach from=$classes item=class}
	    <tr>
		<td><a href="{$site_root_path}?url=admin/showclass&id={$class->id}">{$class->name}</a></td>
		<td>{$class->date_created|date_format}</td>
		<td>   
		{if $class->archive == 0}
		    <a href="{$site_root_path}?url=admin/manageclass&id={$class->id}&source=arch">{t}Click to archive class!{/t}</a>
		{else}	
		    <a href="{$site_root_path}?url=admin/manageclass&id={$class->id}&source=unarch">{t}Click to unarchive class!{/t}</a>
		{/if}	
		</td>
		<td>   
		    <a href="{$site_root_path}?url=admin/manageclass&id={$class->id}&source=del">{t}Click to delete class!{/t}</a>
		</td>		
	    </tr>
	{/foreach}
    </table>
</div>
{include file="_footer.tpl"}
