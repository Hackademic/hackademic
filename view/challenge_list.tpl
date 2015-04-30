{include file="_header_frontend.tpl"}
<div class="main_content">
    <div class="header_bar">
	<div class="page_title"><h3 class="left">{t}Challenges{/t}</h3></div>
    </div><br/>
    <ul style="list-style: none;">
        {foreach from=$list key=class_name item=class_challenges}
					<li>{$class_name}
					<ul style="list-style: none;">

						{foreach from=$class_challenges item=foo}
            <li style="margin-top: 10px; margin-bottom: 10px;">
            {if $foo['availability'] == public || $foo['class'] == true}
                <a class="width100" href="{$site_root_path}?url=showchallenges&id={$foo['id']}&class_id={$foo['class_id']}">
            {/if}
                    <span class="padding_menu">{$foo['title']}</span>
                </a>
            </li>
        {/foreach}
        </ul></li>
        {/foreach}
    </ul>
</div>
{include file="_footer_frontend.tpl"}

