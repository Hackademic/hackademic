            </td>
                    <td id="right_bar" valign="top">
			{if isset($is_logged_in) && isset($challenge_menu)}
			    {if $challenge_menu|@count > 0}
				<!-- Challenge Menu -->
				<div id="menuHeader" class="menubg flt">
				  <ul id="mainMenu" class="menu flt">

					{foreach from=$challenge_menu key=class_name item=class_challenges}
						<li><span class="menuTitle">{$class_name}</span>
							<ul id="classChallenges" class="menu flt">
							{foreach from=$class_challenges item=foo}
								<li>
									<a class="width100" href="{$site_root_path}pages/showchallenges.php?id={$foo['id']}&class_id={$foo['class_id']}">
										<span class="padding_menu">
											{$foo['title']}
										</span>
									</a>
								</li>
							{/foreach}
							</ul>
						</li>
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
