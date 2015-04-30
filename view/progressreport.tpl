{include file="_header_frontend.tpl"}
<div class="main_content">
    <div class="header_bar">
	<div class="page_title"><h3 class="left">{t}Progress Report{/t}</h3></div>
    </div><br/>
    {if isset($search_box)}
	<div class="center">
	    <div id="input_form" style="width: 80%; margin:auto;">
		<form type="GET">
      <input type="hidden" name="url" value="{$smarty.get.url}">
		    <table class="add_form center">
			<tr>
			    <td style="width:25%"><label>{t}Enter a name to search:{/t}</label></td>
			    <td><input type="text" name="username" style="width:80%" value="{if isset($smarty.get.username)}{$smarty.get.username}{/if}"/></td>
			    <td class="submit_btn"><p class="submit"><input class="try_me" type="submit" value="Search" /></p></td>
			</tr>
		    </table>
		</form>
	    </div>
	</div>
    {/if}
    {if (isset($data))}
    {foreach from=$data key=class item=progress}
			
        <table class="manager_table">
        <tr><h4 class="align_center">{$class}</h4></tr>
        <tr>
            <th>{t}Title{/t}</th>
            <th>{t}No. Of Attempts{/t}</th>
            <th>{t}Cleared{/t}</th>
            <th>{t}Cleared On{/t}</th>
        </tr>
			{foreach from=$progress key=index item=foo}
        <tr>
            <td><a href="{$site_root_path}?url=showchallenges&id={$foo['id']}&class_id={$ids[{$class}]}"">{$foo['title']}</a></td>
            <td>{if $foo['attempts'] == 0}{t}Unattempted{/t}{else}{$foo['attempts']}{/if}</td>
            <td>{if $foo['attempts'] == 0}{t}Not Cleared{/t}{elseif $foo['cleared'] == false}{t}Not Cleared{/t}{else}{t}Cleared{/t}{/if}</td>
            <td>{if $foo['cleared'] == true}{$foo['cleared_on']}{else}{t}Not Cleared{/t}{/if}</td>
        </tr>
        
    {/foreach}
 
    {/foreach}
   
    </table>
    {/if}
</div>
{include file="_footer_frontend.tpl"}
