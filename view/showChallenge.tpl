{include file="_header_frontend.tpl"}
<div class="main_content">
    <div class="header_bar">
	<div class="page_title"><h3 class="left">{$challenge->title}</h3></div>
    </div><br/>
<table class="user_add show_challenge" style="height: auto;">
    <tr>
	<td><div class="description">{$challenge->description}<br/><hr/></div></td>
    </tr>
    {if isset($is_logged_in) && isset($is_allowed)}
    <tr id="input_form">
	<td class="submit_btn">
	    <p class="submit"><a id="try_me" target="_blank" href="{$site_root_path}pages/trychallenge.php?id={$challenge->id}">Try it!</a></p>
	</td>
    </tr>
    {/if}
</table>
</div>
{include file="_footer_frontend.tpl"}