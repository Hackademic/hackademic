{include file="_header_frontend.tpl"}
<div class="main_content">
    <div class="header_bar">
	<div class="page_title"><h3 class="left">Challenges</h3></div>
    </div><br/>
    <ul style="list-style: none;">
        {foreach from=$list item=foo}
            <li style="margin-top: 10px; margin-bottom: 10px;">
                <a class="width100" href="{$site_root_path}pages/showchallenges.php?id={$foo['id']}">
                    <span class="padding_menu">{$foo['title']}</span>
                </a>
            </li>
        {/foreach}
    </ul>
</div>
{include file="_footer_frontend.tpl"}