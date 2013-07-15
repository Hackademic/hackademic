<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{if isset($controller_title)}{$controller_title} | {/if}{$app_title}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{$site_root_path}assets/images/favicon.png">
    <link rel="stylesheet" type="text/css" href="{$site_root_path}assets/css/style.css" />
    <link rel="stylesheet" type="text/css" href="{$site_root_path}assets/css/pagination.css" />
    <link rel="stylesheet" type="text/css" href="{$site_root_path}assets/css/base.css" />
</head>
<body>
    <div id="main">
	<div id="headerBar" style="overflow: hidden; padding: 20px 0px 40px 0px;">
	    <div class="left">
            <div class="pad_top_5 margin_left_25">
                <img src="{$site_root_path}user/themes/custom-theme/images/pictogram.gif">
            </div>
	    </div>
	    <div class="pad_25">
		<a href="{$site_root_path}">
            <img style="padding: 30px 0 0 145px;" src="{$site_root_path}user/themes/custom-theme/images/logo.jpg">
		</a>
	    </div>
	</div>
	<div id="content">
	    {if isset($user_menu)}
	    	<div id="username">Hi {$logged_in_user},</div><br/>
		<div id="topMenuHeader">
		    <ul id="topMenu" style="margin: 0;">
			{foreach from=$user_menu item=foo}
			    <li>
				<a href="{$site_root_path}{$foo['url']}">{$foo['title']}</a>
			    </li>
			{/foreach}
		    </ul>
		</div>
	    {/if}
	    <table id="mainTable">
		<tr>
		    <td id="left_bar" valign="top">
                Left bar content here...
			{if isset($main_menu)}
			<!-- Main Menu -->
			<div id="menuHeader" class="menubg flt">
			    <ul id="mainMenu" class="menu flt">
				{foreach from=$main_menu item=foo}
				<li>
				<a class="width100" href="{if !isset($foo['external'])}{$site_root_path}{/if}{$foo['url']}"><span class="padding_menu">{$foo['title']}</span></a></li>
				{/foreach}
			    </ul>
			</div>
			<br/>{/if}<br/>
		    </td>
		    <td id="main_content" valign="top">
			<div id="usermessage">{include file="_usermessage.tpl"}</div>
