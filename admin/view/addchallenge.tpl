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
<div class="main_content">
    <div class="header_bar">
        <div class="page_title"><h3 class="left">Add Challenge</h3></div>
    </div><br/>
    <div id="usermessage">{include file="_usermessage.tpl"}</div>
    {if isset($finish) || (isset($type) && $type=="challenge") || (isset($step) && $step=="step2")}
    <div id="upload_container">
        <form id="input_form" enctype="multipart/form-data" action="" method="post">
            {if isset($finish) || (isset($type) && $type=="challenge")}
                <label>Select a Challenge zip file to upload (or <a href="{$site_root_path}admin/pages/addchallenge.php?type=code">Upload Code</a> only)</label><br/><br/>
            {else}
                <label>Upload Challenge Code Zip File</label><br/><br/>
            {/if}
            <input type="file" name="fupload" />
            <p class="submit"><input type="submit" value="Upload Zip File" /></p>
        </form>
    </div>
    {else}
        <div id="input_form">
            <form id="form" name="form" method="post">
                <table class="article_main">
                    <tr>
                        <td colspan="2">
                            <label>Enter Challenge Details (or <a href="{$site_root_path}admin/pages/addchallenge.php">Upload Challenge</a> directly)</label><br/><br/>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="name">Title</label></td>
                        <td><input type="text" name="title" value="{$cached->title}"/><br/><br/></td>
                    </tr>
                    <tr>
                        <td><label for="name">Authors</label></td>
                        <td><input type="text" name="authors" value="{$cached->authors}"/><br/><br/></td>
                    </tr>
                    <tr>
                        <td><label for="name">Category</label></td>
                        <td><input type="text" name="category" value="{$cached->category}"/><br/><br/></td>
                    </tr>
		    <tr>
                        <td><label for="name">Level</label></td>
                        <td><input type="text" name="level" value="{$cached->level}"/><br/><br/></td>
                    </tr>
                    <tr>
                        <td><label for="name">Duration</label></td>
                        <td><input type="text" name="duration"placeholder="minutes" value="{$cached->duration}"/><br/><br/></td>
                    </tr>
                    <tr>
                        <td><label for="name">Description</label></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <textarea name="description" style="width:100%">{$cached->description}</textarea><br/><br/>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <p class="submit"><input type="submit" name="continue" value="Continue" /></p>
                        </td>
                    </tr>
                </table>
            </form>		
        </div>
    {/if}
</div>
{include file="_footer.tpl"}
