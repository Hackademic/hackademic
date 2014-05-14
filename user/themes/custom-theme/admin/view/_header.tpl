<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{if isset($controller_title)}{$controller_title} | {/if}{$app_title}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{$site_root_path}assets/images/favicon.png">
    <link rel="stylesheet" type="text/css" href="{$site_root_path}admin/assets/css/style.css" />
    <link rel="stylesheet" type="text/css" href="{$site_root_path}admin/assets/css/base.css" />
   
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <!--<script type="text/javascript" src="js/main.js"></script>-->
</head>
<body>
  <div id="main">
    <div id="headerBar" style="overflow: hidden; padding: 20px 0px 40px 0px;">
    <div class="left">
          <div class="pad_top_5 margin_left_25">
              <img src="{$site_root_path}user/themes/custom-theme/view/images/pictogram.gif">
          </div>
    </div>
    <div class="pad_25">
	    <a href="{$site_root_path}">
        <img style="padding: 30px 0 0 145px;" src="{$site_root_path}user/themes/custom-theme/view/images/logo.jpg">
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
  		    {foreach from=$main_menu_admin['parents'][0] item=itemId}
            <li class="menu-item">
              <a href="{$site_root_path}?url={$main_menu_admin['items'][$itemId]['url']}">{$main_menu_admin['items'][$itemId]['label']}</a>
              {if isset($main_menu_admin['parents'][$itemId])}
                <ul class="sub-menu">
                {foreach from=$main_menu_admin['parents'][$itemId] item=subItemId}
                  <li>
                    <a href="{$site_root_path}?url={$main_menu_admin['items'][$subItemId]['url']}">{$main_menu_admin['items'][$subItemId]['label']}</a>
                  </li>
                {/foreach}
                </ul>
              {/if}
            </li>
  		    {/foreach}
    		</ul>
	    </div>
      <br/>{/if}<br/>
      