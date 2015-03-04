{include file="_header_frontend.tpl"}
<div class="main_content">
    <div class="header_bar">
        <div class="page_title">
            <h3 class="left">{$challenge->title}</h3>
        </div>
    </div><br/>
    <table class="user_add show_challenge" style="height: auto;">
        <tr>
            <td>
                <div>{$challenge->description}<br/><hr/></div>
            </td>
        </tr>

        {foreach from=$clues key=num item=clue}
            {if $clue->opened}
            <tr>
                <td>
                    <div class="show_clue"><u>Clue {$num+1}:</u> {$clue->clue_text}</div></td>
            </tr>
            {else}
            <tr>
                <td>
                    <form method="post" class="show_clue">
                        <input type="hidden" name="clue" value="{$clue->id}"/>
                        <input type="submit" class="show_clue_button" name="show_clue" value="Show clue {$num+1}"/>
                    </form>
                </td>
            </tr>
            {/if}
        {/foreach}

        {if isset($is_logged_in) && isset($is_allowed)}
        <tr id="input_form">
        <td class="submit_btn">
        <p class="submit"><a id="try_me" target="_blank" href="{$site_root_path}?url=trychallenge&id={$challenge->id}&user={$username}&class_id={$class_id}">Try it!</a></p>
        </td>
        </tr>
        {/if}
    </table>
</div>
{include file="_footer_frontend.tpl"}
