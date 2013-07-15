{include file="_header.tpl"}

<div class="main_content">
    <div class="header_bar">
        <div class="page_title"><h3 class="left">Options</h3></div>
    </div>

    <div id="input_form" class="options_form">
        <form method="post" action="{$site_root_path}admin/pages/options.php">
         <h4>Plugins</h4>
        {if !empty($plugins)}
          {foreach from=$plugins key=k item=plugin}
            <div class="form_section">
              <div class="plugin_information">
                <h5>{$plugin['Name']} <span class="plugin_version">{$plugin['Version']}</span></h5>
                {if !empty($plugin['Description'])}
                  <p class="plugin_details">{$plugin['Description']|escape:'html'}</p>
                {/if}
                {if !empty($plugin['PluginURI'])}
                  <p class="plugin_details">
                    Plugin URI: <a href="{$plugin['PluginURI']}">{$plugin['PluginURI']|escape:'html'}</a>
                  </p>
                {/if}
                {if !empty($plugin['Author'])}
                  <p class="plugin_details">Author: {$plugin['Author']|escape:'html'}</p>
                {/if}
                {if !empty($plugin['AuthorURI'])}
                  <p class="plugin_details">
                    Author URI: <a href="{$plugin['AuthorURI']}">{$plugin['AuthorURI']|escape:'html'}</a>
                  </p>
                {/if}
              </div>
              <div class="form_item">
                <input type="checkbox" name="plugin_{$k|escape:'html'}" value="{$k|escape:'html'}" {if in_array($k, $active_plugins)} checked{/if}/>
              </div>
            </div>
          {/foreach}
        {else}
          <div class="form_section">
            <p class="plugin_details">No plugins installed at the moment. You can add plugins to Hackademic Challenges in the plugins folder.</p>
          </div>
        {/if}
        <h4>User themes</h4>
        <div class="form_section">
           <div class="plugin_information">
                <h5>System</h5>
                <p class="plugin_details">The default system theme.</p>
            </div>
            <div class="form_item">
                <input type="radio" name="active_user_theme" value="{$system_theme}" {if $active_user_theme == $system_theme} checked{/if}/>
            </div>
        </div>
        {foreach from=$user_themes key=k item=user_theme}
        <div class="form_section">
            <div class="plugin_information">
                <h5>{$user_theme['Name']|escape:'html'} <span class="plugin_version">{$user_theme['Version']|escape:'html'}</span></h5>
                {if !empty($user_theme['Description'])}
                    <p class="plugin_details">{$user_theme['Description']|escape:'html'}</p>
                {/if}
                {if !empty($user_theme['PluginURI'])}
                    <p class="plugin_details">
                        Theme URI: <a href="{$user_theme['PluginURI']|escape:'url'}">{$user_theme['PluginURI']|escape:'html'}</a>
                    </p>
                {/if}
                {if !empty($user_theme['Author'])}
                    <p class="plugin_details">Author: {$user_theme['Author']|escape:'html'}</p>
                {/if}
                {if !empty($user_theme['AuthorURI'])}
                    <p class="plugin_details">
                        Author URI: <a href="{$user_theme['AuthorURI']|escape:'url'}">{$user_theme['AuthorURI']|escape:'html'}</a>
                    </p>
                {/if}
            </div>
            <div class="form_item">
                <input type="radio" name="active_user_theme" value="{$k|escape:'html'}" {if $k == $active_user_theme} checked{/if}/>
            </div>
        </div>
        {/foreach}
        <div class="form_section submit_section">
            <p class="submit"><input type="submit" name="submit" id="submit" value="Submit" /></p>
        </div>
    </div>
</div>
{include file="_footer.tpl"}