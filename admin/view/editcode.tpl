{include file="_header.tpl"}
<div class="main_content">
    <div class="header_bar">
        <div class="page_title"><h3 class="left">Edit Code - {$title}</h3></div>
    </div><br/>
    <div id="usermessage">{include file="_usermessage.tpl"}</div>
    <div id="input_form">
        <form id="form" name="form" method="post">
            <table class="article_main">
                <tr>
                    <td>
                        <label for="name">
                            This section allows you to only edit the challenge index.php file.
                            To edit other parts of the challenge, its recommended that you download the challenge,
                            and reupload it once you have made the necessary changes.
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
                            <a href="{$site_root_path}admin/pages/download.php?ch={$folder}" name="submit">Download Challange</a>
                        </p>
                    </td>
                </tr>
            </table>
        </form>		
    </div>
</div>
{include file="_footer.tpl"}