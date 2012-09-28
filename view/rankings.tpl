{include file="_header_frontend.tpl"}
<div class="main_content">
    <div class="header_bar">
	<div class="page_title"><h3 class="left">Rankings</h3></div>
    </div><br/>
    {if isset($is_logged_in)}
    <div class="center">
	<div id="input_form" style="width: 80%; margin:auto;">
	    <form type="GET">
		<table class="add_form center">
		    <tr>
			<td style="width:25%"><label>Select Class:</label></td>
			<td>
			    <select name="class" style="width:100%">
				{foreach from=$classes item=cls}
				    <option value="{$cls->id}" {if isset($smarty.get.class) && $cls->id == $smarty.get.class}selected="selected"{/if}>{$cls->name}</option>
				{/foreach}
			    </select>
			</td>
			<td class="submit_btn"><p class="submit"><input class="try_me" type="submit" value="Search" /></p></td>
		    </tr>
		</table>
	    </form>
	</div>
    </div>
    {/if}
    {if (isset($rankings))}
    <table class="manager_table">
        <tr>
            <th>Username</th>
            <th>Challenges Cleared</th>
						<th>Rank</th>
						<th>Total Points</th>
        </tr>
    {foreach from=$rankings item=foo}
        <tr>
            <td>{$foo['username']}</a></td>
            <td>{$foo['count']}</td>
						<td>{$foo['rank']}</td>
						<td>{$foo['score']}</td>
        </tr>
    {/foreach}
    </table>
    {/if}
</div>
{include file="_footer_frontend.tpl"}
