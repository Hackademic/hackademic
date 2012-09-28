{include file="_header.tpl"}
<link rel="stylesheet" type="text/css" href="{$site_root_path}assets/css/pagination.css"/>

<div class="main_content">
    <div class="header_bar">
	<div class="page_title"><h3 class="left">Article Manager</h3></div>
    </div><br/>
    
    <div id="input_form">
	<form method ="get">
	    <table class="add_form center">
		<tr>
		    <td class="width_40">Search:  <input class="width_90" type="text" name="search" id="search" placeholder="Search Text"/></td>
		    <td class="width_10">Sort By:</td>
		    <td class="width_25">
			  <select name="category" class="width_90">
			    <option value="title">Title</option> 
			    <option value="created_by">Author</option> 
			    <option value="last_modified_by">Last modified by</option> 
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
	    <th align = "left">Title</th>
	    <th align = "left">Date posted</th>
	    <th align = "left">Author</th>
	    <th align = "left">Last Modified</th>
	    <th align = "left">Last modified by</th>
	    <th align = "left">Published</th>
	</thead>
	{foreach from=$articles item=article}
	    <tr>
		<td><a href="{$site_root_path}admin/pages/editarticle.php?id={$article->id}">{$article->title}</a></td>
		<td>{$article->date_posted|date_format}</td>
		<td>{$article->created_by}</td>
		<td>{if $article->last_modified}{$article->last_modified|date_format}{else}-{/if}</td>
		<td>{if $article->last_modified}{$article->last_modified_by}{else}-{/if}</td>
		<td>{if $article->is_published}Yes{else}No{/if}</td>
	    </tr>
	{/foreach}
    </table>
	 
</div>
{include file="_footer.tpl"}
