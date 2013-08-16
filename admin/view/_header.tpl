<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{if isset($controller_title)}{$controller_title} | {/if}{$app_title}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{$site_root_path}assets/images/favicon.png">
    <link rel="stylesheet" type="text/css" href="{$site_root_path}admin/assets/css/style.css" />
    <link rel="stylesheet" type="text/css" href="{$site_root_path}admin/assets/css/base.css" />
   
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="js/main.js"></script>
</head>
<body>
    <div id="main">
	<div id="headerBar">
	    <div class="left">
		<div class="pad_top_5 margin_left_25">
		    <a href="http://www.owasp.org" target="_blank">
		    <!-- style used inline because it will not be repeated elsewhere in the webapp -->
			<img id="orglogo" src="{$site_root_path}assets/images/owasp.png">
		    </a>
		</div>
	    </div>
	    <div class="center pad_25">
		<a href="{$site_root_path}">
		    <img id="logo" src="{$site_root_path}assets/images/logo.png">
		</a>
	    </div>     
	</div>	
	<div id="content">
	    {if isset($main_menu_admin)}
	    <div>
		
	    </div><br/>
	    <!-- Main Menu -->
	    <div id="menuHeader"> 
		<ul id="mainMenu">
			<em id="username">Hi {$logged_in_user},</em>
		    {foreach from=$main_menu_admin item=foo}
		    <li><a href="{$site_root_path}{$foo['url']}">{$foo['title']}</a></li>
		    {/foreach}
		</ul>
	    </div><br/>{/if}<br/>
