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
	    {if isset($user_menu)}
	  <!--  	<div id="username">Hi {$logged_in_user},</div><!--<br/>-->
		<div id="topMenuHeader"> 
		    <ul id="topMenu">
			    <em id="username">Hi {$logged_in_user},</em><!--<br/>-->
  		    {foreach from=$user_menu['parents'][0] item=itemId}
            <li class="menu-item">
              <a href="{$site_root_path}?url={$user_menu['items'][$itemId]['url']}">{$user_menu['items'][$itemId]['label']}</a>
              {if isset($user_menu['parents'][$itemId])}
                <ul class="sub-menu">
                {foreach from=$user_menu['parents'][$itemId] item=subItemId}
                  <li>
                    <a href="{$site_root_path}?url={$user_menu['items'][$subItemId]['url']}">{$user_menu['items'][$subItemId]['label']}</a>
                  </li>
                {/foreach}
                </ul>
              {/if}
            </li>
  		    {/foreach}
		    </ul>
		</div>
	    {/if}
	    <table id="mainTable">
		<tr>
		    <td id="left_bar" valign="top">			
			    <br/>
		    </td>
		    <td id="main_content" valign="top">
			<div id="usermessage">{include file="_usermessage.tpl"}</div>
	