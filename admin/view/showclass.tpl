{include file="_header.tpl"}
<link rel="stylesheet" type="text/css" href="{$site_root_path}assets/css/pagination.css"/>
<div class="main_content">
    <div class="header_bar">
	<div class="page_title"><h3 class="left">{t}Class Memberships{/t} - {$class->name}</h3></div>
    </div><br/>
    <div id="usermessage">{include file="_usermessage.tpl"}</div>

   <form id="form" name="form" method="post">
      <table class="manager_table">
              <tr>
		     <td><label>{t}Name:  {/t}</label></td>
		     <td><input type="text" name="updateclassname" value="{$class->name}"/></td>

                  <td colspan="2">
		        <p class="submit">

		        </p>
		      </td>
		      <td>

		<!--<a href="challengemanager.php">Add challenges</a>-->
		<select name="challenges" class="width_90">
			    <option value="default">{t}Add challenges{/t}</option>
			    {foreach from=$challenges_not_assigned item=challenge}
			    <option value="{$challenge['id']}">{$challenge['title']}</option>
			    {/foreach}
			</select>
	    </td>
	     <td class="submit_btn width_10">
			<p class="submit"><input type="submit" name="submit" id="submit" value="Update" /></p>
		    </td>

	     <td>
		<a href="?url=admin/usermanager">{t}Add users{/t}</a>
	    </td>
	    </tr>
	    <tr></tr>
      </table>
   </form>
    <table class="manager_table">
	  <thead>
	    <th>{t}Username{/t}</th>
	    <th>{t}Remove{/t}</th>
	</thead>
	{foreach from=$users item=user}
	    <tr>
		<td>{$user['username']}</td>
		<td><a href="{$site_root_path}?url=admin/showclass&uid={$user['user_id']}&id={$class->id}&action=del">{t}Remove{/t}</a></td>
	    </tr>
	{/foreach}
    </table>
    <br/><br/>
    <table class="manager_table">
	<thead>
	    <th>{t}Challenge{/t}</th>
	    <th>{t}Remove{/t}</th>
	    <th>{t}Edit Scoring Rules{/t}</th>
	</thead>
	{foreach from=$challenges item=challenge}
	    <tr>
		<td>{$challenge['title']}</td>
		<td><a href="{$site_root_path}?url=admin/showclass&cid={$challenge['challenge_id']}&id={$class->id}&action=del">{t}Remove{/t}</a></td>
		<td><a href="{$site_root_path}?url=admin/scoringrules&cid={$challenge['challenge_id']}&class_id={$class->id}">{t}Edit{/t}</a></td>
	    </tr>
	{/foreach}
    </table>
</div>
{include file="_footer.tpl"}
