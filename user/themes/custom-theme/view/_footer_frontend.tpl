            </td>
                    <td id="right_bar" valign="top">
                        {if isset($is_logged_in) && isset($challenge_menu)}
                            {if $challenge_menu|@count > 0}
                          <!-- Challenge Menu -->
                          <div id="menuHeader" class="menubg flt">
                              <ul id="mainMenu" class="menu flt">
                            {foreach from=$challenge_menu item=foo}
                            <li>
                            <a class="width100" href="{$site_root_path}?url=showchallenges&id={$foo['id']}"><span class="padding_menu">{$foo['title']}</span></a></li>
                            {/foreach}
                              </ul>
                          </div>
                            {/if}
                        {else}
                            {include file="user_login.tpl"}
                        {/if}
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>