{include file="_header.tpl"}
<link rel="stylesheet" type="text/css" href="{$site_root_path}assets/css/pagination.css"/>
<div class="main_content">
    <div class="header_bar">
	<div class="page_title"><h3 class="left">Module Names - {$module->name}</h3></div>
    </div><br/>
    <div id="usermessage">{include file="_usermessage.tpl"}</div>

   <form id="form" name="form" method="post">
      <table class="manager_table">
              <tr>
		     <td><label>Name:  </label></td>
		     <td><input type="text" name="updatename" value="{$module->name}"/></td>

                  <td colspan="2">
		        <p class="submit">

		        </p>
		      </td>
		      <td>

		<!--<a href="challengemanager.php">Add challenges</a>-->
		<select name="challenges" class="width_90">
			    <option value="default">Add challenges</option>
			    {foreach from=$challenges_not_assigned item=challenge}
			    <option value="{$challenge['id']}">{$challenge['title']}</option>
			    {/foreach}
			</select>
	    </td>
	    
	     <td class="submit_btn width_10">
			<p class="submit"><input type="submit" name="submit" id="submit" value="Update" /></p>
		    </td>
		 <td>
		<select name="articles" class="width_90">
			    <option value="default">Add articles</option>
			    {foreach from=$articles_not_assigned item=article}
			    <option value="{$article['id']}">{$article['title']}</option>
			    {/foreach}
			</select>
	    </td>
	    </tr>
	    <tr></tr>
      </table>
   </form>
    <table class="manager_table">
	  <thead>
	    <th>Article</th>
	    <th>Remove</th>
	</thead>
	{foreach from=$articles item=article}
	    <tr>
		<td>{$article['title']}</td>
		<td><a href="{$site_root_path}?url=admin/editmodule&aid={$article['id']}&id={$module->id}&action=del">Remove</a></td>
	    </tr>
	{/foreach}
    </table>
    <br/><br/>
    <table class="manager_table">
	<thead>
	    <th>Challenge</th>
	    <th>Remove</th>
	    <th>Edit Scoring Rules</th>
	</thead>
	{foreach from=$challenges item=challenge}
	    <tr>
		<td>{$challenge['title']}</td>
		<td><a href="{$site_root_path}?url=admin/showclass&cid={$challenge['challenge_id']}&id={$class->id}&action=del">Remove</a></td>
		<td><a href="{$site_root_path}?url=admin/scoringrules&cid={$challenge['challenge_id']}&class_id={$class->id}">Edit</a></td>
	    </tr>
	{/foreach}
    </table>
</div>
{include file="_footer.tpl"}
