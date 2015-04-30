{include file="_header.tpl"}

<div class="main_content">
    <div class="header_bar">
        <div class="page_title"><h3 class="left">{t}Options{/t}</h3></div>
    </div>

    <div id="input_form" class="options_form">
        <form method="post" action="{$site_root_path}?url=admin/options">
         <h4>{t}Plugins{/t}</h4>
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
                   {t} Plugin URI: {/t}<a href="{$plugin['PluginURI']}">{$plugin['PluginURI']|escape:'html'}</a>
                  </p>
                {/if}
                {if !empty($plugin['Author'])}
                  <p class="plugin_details">{t}Author:{/t} {$plugin['Author']|escape:'html'}</p>
                {/if}
                {if !empty($plugin['AuthorURI'])}
                  <p class="plugin_details">
                    {t}Author URI: {/t}<a href="{$plugin['AuthorURI']}">{$plugin['AuthorURI']|escape:'html'}</a>
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
            <p class="plugin_details">{t}No plugins installed at the moment. You can add plugins by droping the plugin files in the plugins folder.{/t}</p>
          </div>
        {/if}
        <h4>{t}User themes{/t}</h4>
        <div class="form_section">
           <div class="plugin_information">
                <h5>{t}System{/t}</h5>
                <p class="plugin_details">{t}The default system theme.{/t}</p>
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
                        {t}Theme URI:{/t} <a href="{$user_theme['PluginURI']|escape:'url'}">{$user_theme['PluginURI']|escape:'html'}</a>
                    </p>
                {/if}
                {if !empty($user_theme['Author'])}
                    <p class="plugin_details">{t}Author:{/t} {$user_theme['Author']|escape:'html'}</p>
                {/if}
                {if !empty($user_theme['AuthorURI'])}
                    <p class="plugin_details">
                        {t}Author URI: {/t}<a href="{$user_theme['AuthorURI']|escape:'url'}">{$user_theme['AuthorURI']|escape:'html'}</a>
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