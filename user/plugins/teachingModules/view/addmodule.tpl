{include file="_header.tpl"}

<div class="main_content">
    <div class="header_bar">
	<div class="page_title"><h3 class="left">Add Module</h3></div>
    </div><br/>
    <div id="usermessage">{include file="_usermessage.tpl"}</div>
    <div id="input_form">
            <form id="input_form" enctype="multipart/form-data" action="" method="post">
                <table class="user_add">
                <tr>
                <td>
                <label>Upload Module Zip File</label><br/><br/></td>
                </td>
                <td>
            <input type="file" name="fupload" /></td>
            <tr class="submit_btn">
		<td colspan="2">
            <p class="submit"><input type="submit" value="Upload Zip File" /></p></td></tr>
        </table>
        </form>
        
    <form id="form" name="form" method="post">
	<table class="user_add">
	    <tr>
		<td><label for="name">Name</label></td>
		<td><input type="text" name="modulename" value="{$cached->name}"/></td>
		<td colspan="2">
		    <p class="submit"><input type="submit" name="submit" id="submit" value="Add Module" /></p>
		</td>
	    </tr>
	</table>
    </form>
    </div>
</div>
{include file="_footer.tpl"}
