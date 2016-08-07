{include file="_header.tpl"}
<link rel="stylesheet" type="text/css" href="{$site_root_path}assets/css/pagination.css"/>
<div class="main_content">
    <div class="header_bar">
	<div class="page_title"><h3 class="left">Class Memberships - {$class->name}</h3></div>
    </div><br/>
    <div id="usermessage">{include file="_usermessage.tpl"}</div>
  
   <form id="form" name="form" method="post">
      <table class="manager_table">
              <tr>
		     <td><label>Edit Class Name  </label></td>
		     <td><input type="text" name="updateclassname" value="{$class->name}"/></td>
            
                  <td colspan="2">
		        <p class="submit">
			   <input type="submit" name="submit" id="submit" value="Edit ClassName" />
		        </p>
		      </td>
	    </tr>
      </table>
   </form>  
    <table class="manager_table">
	  <thead>
	    <th>Username</th>
	    <th>Remove</th>
	</thead>
	{foreach from=$users item=user}
	    <tr>  
		<td>{$user['username']}</td>
		<td><a href="{$site_root_path}admin/pages/showclass.php?uid={$user['user_id']}&id={$class->id}&action=del">Remove</a></td>
	    </tr>
	{/foreach} 			
    </table>
    <br/><br/>
    <table class="manager_table">
	<thead> 
	    <th>Challenge</th>
	    <th>Remove</th>
	</thead>
	{foreach from=$challenges item=challenge}
	    <tr>  
		<td>{$challenge['title']}</td>
		<td><a href="{$site_root_path}admin/pages/showclass.php?cid={$challenge['challenge_id']}&id={$class->id}&action=del">Remove</a></td>
	    </tr>
	{/foreach} 			
    </table>
</div>
{include file="_footer.tpl"}