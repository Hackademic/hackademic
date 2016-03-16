{include file="_header.tpl"}
<script type="text/javascript" src="{$site_root_path}extlib/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
    // General options
    mode : "textareas",
    theme : "advanced",
    plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

    // Theme options
    theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
    theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
    theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
    theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_statusbar_location : "bottom",
    theme_advanced_resizing : true,

    // Skin options
    skin : "o2k7",
    skin_variant : "silver",

    // Example content CSS (should be your site CSS)
    content_css : "css/example.css",

    // Drop lists for link/image/media/template dialogs
    template_external_list_url : "js/template_list.js",
    external_link_list_url : "js/link_list.js",
    external_image_list_url : "js/image_list.js",
    media_external_list_url : "js/media_list.js",

    // Replace values for the template plugin
    template_replace_values : {
        username : "Some User",
        staffid : "991234"
    }
});
</script>
<script type="text/javascript">
    $(function() {
        $('#add_clue').click(function() {
            addClue();
        });
    });

    function addClue() {
        // Adds a new clue sub-form:
        var clueNum = parseInt($('#nb_clues').val());
        var subForm = '<tr class="clue clue'+clueNum+'"><td><label>Clue '+(clueNum + 1)+'</label></td>' +
                '<td><input type="text" name="clue'+clueNum+'_text"/>&nbsp;&nbsp;&nbsp;' +
                '<a href="#" onclick="return deleteClue(this.id);" id="delete_clue'+clueNum+'">delete clue</a><br/></td>' +
                '</tr><tr class="clue clue'+clueNum+'">' +
                '<td><label>Penalty for clue '+(clueNum + 1)+'</label></td>' +
                '<td><input type="text" name="clue'+clueNum+'_penalty" value="0"/><br/></td>' +
                '</tr><tr class="clue clue'+clueNum+'">' +
                '<td><label>State of clue '+(clueNum + 1)+'</label></td>' +
                '<td><select name="clue'+clueNum+'_state">' +
                '<option value="disabled" selected="selected">Disabled</option>' +
                '<option value="enabled">Enabled</option>' +
                '</select><br/><br/></td></tr>';
        $('#add_clue_row').before(subForm);

        // Increments the number of clue.
        $('#nb_clues').val(clueNum + 1);
    }

    function deleteClue(idClueRemoved) {
        // Updates the number of the other clues:
        var indexClueRemoved = parseInt(idClueRemoved.substr(11, 1)); // removes 'delete_clue' from the id.

        // Deletes the subform for this clue:
        $('.clue'+indexClueRemoved).remove();

        $('.clue').each(function(index) {
            if(index >= indexClueRemoved * 3) {
            // Clues after the one that will be removed.
                var newIndexClue = parseInt(index / 3);
                var oldIndexClue = newIndexClue + 1;

                // Decrement the numbers after the one removed:
                $(this).removeClass('clue'+oldIndexClue).addClass('clue'+newIndexClue);
                $(this).find('input, select').each(function() {
                    $(this).attr('name', $(this).attr('name').replace('clue'+oldIndexClue, 'clue'+newIndexClue));
                });
                $(this).find('a').each(function() {
                    $(this).attr('id', $(this).attr('id').replace('clue'+oldIndexClue, 'clue'+newIndexClue));
                });
                $(this).find('label').each(function() {
                    $(this).text($(this).text().replace('lue '+(oldIndexClue + 1), 'lue '+(newIndexClue + 1)));
                });
            }
        });

        // Updates the number of clues:
        $('#nb_clues').val($('#nb_clues').val() - 1);

        return false;
    }
</script>
<div class="main_content">
    <div class="header_bar">
        <div class="page_title"><h3 class="left">Edit Challenge</h3></div>
    </div><br/>
	 <div id="usermessage">{include file="_usermessage.tpl"}</div>
	  <div id="input_form">
    <form id="form" name="form" method="post">
	<table class="article_main">
	<tr><td>
		   	<p class="submit left" id="try_me"><a href="{$site_root_path}?url=admin/editcode&id={$challenge->id}" name="submit">Edit Code</a></p></td>
		</tr>
	    <tr>
		<td><label for="name">Title</label></td>
		<td><input type="text" name="title" value="{$challenge->title}"/></td>
	    </tr>
	    <tr>
		<td><label for="name">Description</label></td>
	    </tr>
	    <tr>
                <td colspan="2">
                    <textarea name="description" style="width:100%">{$challenge->description}</textarea>
                </td>
            </tr>
		
		
		<tr>
		<td><label for="visibility">Visibility</label></td>
		<td><select name="visibility">
			   {if $challenge->visibility=="public"}
               <option value="public" selected="selected">Public</option>
			   <option value="private" >Private</option>
			   {else $challenge->visibility=="private"}
               <option value="private" selected="selected">Private</option>
			   <option value="public" >Public</option>
			   {/if}
			   </select></td>
		</tr>
		<tr>
		<td><label for="availability">Availability</label></td>
		<td><select name="availability">
			    {if $challenge->availability=="public"}
               <option value="public" selected="selected">Public</option>
			   <option value="private" >Private</option>
			   {else $challenge->availability=="private"}
               <option value="private" selected="selected">Private</option>
			   <option value="public" >Public</option>
			   {/if}
			   </select></td>
		
		</tr>
		<tr>
		<td><label for="publish">Published</label></td>
		<td><select name="publish">
			    {if $challenge->publish==0}
               <option value="0" selected="selected">Not published</option>
			   <option value="1" >Publish</option>
			   {else}
               <option value="1" selected="selected">Publish</option>
			   <option value="0" >Public</option>
			   {/if}
			   </select></td>
		</tr>
		 <tr>
		<td><label for="level">Level</label></td>
		<td><input type="text" name="level" value="{$challenge->level}"/></td>
		</tr>
		 <tr>
		<td><label for="duration">Duration(minutes)</label></td>
		<td><input type="text" name="duration" value="{$challenge->duration}"/></td>
		</tr>

		{foreach from=$clues key=num item=clue}
		<tr class="clue clue{$num}">
			<td><label>Clue {$num + 1}</label></td>
			<td>
				<input type="hidden" name="clue{$num}_id" value="{$clue->id}"/>
				<input type="text" name="clue{$num}_text" value="{$clue->clue_text}"/>&nbsp;&nbsp;&nbsp;
				<a href="#" onclick="return deleteClue(this.id);" id="delete_clue{$num}">delete clue</a><br/>
			</td>
		</tr>
		<tr class="clue clue{$num}">
			<td><label>Penalty for clue {$num + 1}</label></td>
			<td><input type="text" name="clue{$num}_penalty" value="{$clue->penalty}"/><br/></td>
		</tr>
		<tr class="clue clue{$num}">
			<td><label>State of clue {$num + 1}</label></td>
			<td>
				<select name="clue{$num}_state">
					{if $clue->enabled}
					<option value="enabled" selected="selected">Enabled</option>
					<option value="disabled">Disabled</option>
					{else}
					<option value="disabled" selected="selected">Disabled</option>
					<option value="enabled">Enabled</option>
					{/if}
				</select><br/><br/>
			</td>
		</tr>
		{/foreach}

		<tr id="add_clue_row">
			<td>
				<p class="submit">
					<input type="hidden" id="nb_clues" name="nb_clues" value="{count($clues)}" />
					<input type="button" id="add_clue" value="Add a clue" />
				</p>
			</td>
		</tr>

		<tr>
		    <td>
			<p class="submit"><input type="submit" name="submit" value="Update Challenge Details" /></p>
		    </td>
		    <td>
		  </td>
		</tr>
	    
</table>

</form>		
</div>
</div>
	   
{include file="_footer.tpl"}
