{include file="_header.tpl"}
<link rel="stylesheet" type="text/css" href="{$site_root_path}assets/css/pagination.css"/>
<div class="main_content">
    <div class="header_bar">
	<div class="page_title"><h3 class="left">Scoring Rules For: <span style="color:black">{$class_name}</span> Challenge: <span style="color:black">{$challenge_name}</span></h3></div>
    </div><br/>
    <div id="usermessage">{include file="_usermessage.tpl"}</div>
    <br/><br/>
    <table class="manager_table">
	<thead>
	    <th>Rule Name</th>
	    <th>Value</th>
	</thead>
	<form method=POST>
	{foreach from=$rules key=name item=rule}
	    <tr>
		<td>{$rule_names[$name]}</td>
		<td colspan="2">
		{if $name == 'banned_user_agents'}
			<input style="width:100%;" type="textbox" name="{$name}" value="{$rule}"/>
		{else}
			<input type="number" name="{$name}" value="{$rule}"/>
	 {/if}</td>
	    </tr>
	{/foreach}
	 <tr class="submit_btn">
		<td colspan="2">
		    <p class="submit">
			<input type="submit" name="updaterule" id="submit" value="Edit Rule" />
			<input type="submit" name="deleterule" id="deletesubmit" value="Delete Rule" />
			</p>
			</td>
			</tr>
	</form>
    </table>
</div>
{include file="_footer.tpl"}
