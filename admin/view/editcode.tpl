{include file="_header.tpl"}
<div class="main_content">
    <div class="header_bar">
        <div class="page_title"><h3 class="left">{t}Edit Code - {/t}{$title}</h3></div>
    </div><br/>
    <div id="usermessage">{include file="_usermessage.tpl"}</div>
    <div id="input_form">
        <form id="form" name="form" method="post">
	    <input type="hidden" name="csrf_token" value="{$token}">
            <table class="article_main">
                <tr>
                    <td>
                        <label for="name">
                            {t} This section allows you to only edit the challenge index.php file.
                            To edit other parts of the challenge, its recommended that you download the challenge,
                            and reupload it once you have made the necessary changes. {/t}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <textarea name="code" style="width:100%">{$file_contents}</textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="submit"><input type="submit" name="submit" value="Submit" /></p>
                    </td>
                    <td>
		     	<p class="submit right" id="try_me" style="width: 130px">
                            <a href="{$site_root_path}?url=admin/download&ch={$folder}" name="submit">{t}Download Challange{/t}</a>
                        </p>
                    </td>
                </tr>
            </table>
        </form>		
    </div>
</div>
{include file="_footer.tpl"}
