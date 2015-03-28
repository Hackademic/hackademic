{include file="_header.tpl"}
<link rel="stylesheet" type="text/css" href="{$site_root_path}assets/css/pagination.css"/>

<div class="main_content">
  <div class="header_bar">
    <div class="page_title">
      <h3 class="left">Menu Manager</h3>
    </div>
  </div>
  <br/>
  <div id="usermessage">{include file="_usermessage.tpl"}</div>
  <br/>
  <div id="input_form">

  	<form id="menumanager-form" method="post" action="?url=admin/menumanager">
		<input type="hidden" name="csrf_token" value="{$token}">
      <input type="hidden" name="number_of_items" value="{$selected_menu->items['items']|@sizeof}"/>
      <input type="hidden" name="mid" value="{$selected_menu->mid}"/>
      <div>
        <div id="option-wrapper">
          <select name="menu">
            {foreach from=$menus item=menu}
              <option value="{$menu['mid']}" {if $menu['mid'] eq $selected_menu->mid} selected {/if}>{$menu['name']}</option>
            {/foreach}
          </select>
          <p class="submit">
            <input type="submit" value="Change" id="change" name="submit">
          </p>
        </div>
        <br/>
        <div id="item-wrapper">
          <div class="dd"> 
            <ol class="dd-list">        
      		    {foreach from=$selected_menu->items['parents'][0] item=itemId}
                <li class="dd-item" data-id="{$itemId}">
                   <div class="dd-handle">{$selected_menu->items['items'][$itemId]['label']}</div>
                   <div class="dd-sort">
                     <select class="parent" name="parent-{$itemId}">
                       <option value="0"> No parent </option>
                       {foreach from=$selected_menu->items['items'] item=menuItem}
                         {if $itemId neq $menuItem['id']}
                           <option value="{$menuItem['id']}" {if $menuItem['id'] eq $selected_menu->items['items'][$itemId]['parent']} selected {/if}>
                               {$menuItem['label']}
                           </option>
                         {/if}
                       {/foreach}
                     </select>
                     <select class="sort" name="sort-{$itemId}">
                       {for $sort=0 to count($selected_menu->items['items'])}
                         <option value="{$sort}" {if $sort eq $selected_menu->items['items'][$itemId]['sort']} selected {/if}>
                           {$sort}
                         </option>
                       {/for}
                     </select>
                  </div>
                  {if isset($selected_menu->items['parents'][$itemId])}
                    <ol class="dd-list">
                      {foreach from=$selected_menu->items['parents'][$itemId] item=subItemId}
                        <li class="dd-item" data-id="{$subItemId}">
                          <div class="dd-handle">{$selected_menu->items['items'][$subItemId]['label']}</div>
                          <div class="dd-sort">
                            <select class="parent" name="parent-{$subItemId}">
                              <option value="0"> No parent </option>
                              {foreach from=$selected_menu->items['items'] item=menuItem}
                                  <option value="{$menuItem['id']}" {if $menuItem['id'] eq $selected_menu->items['items'][$subItemId]['parent']} selected {/if}>
                                      {$menuItem['label']}
                                  </option>
                              {/foreach}
                            </select>
                            <select class="sort" name="sort-{$subItemId}">
                              {for $sort=0 to count($selected_menu->items['items'])}
                                <option value="{$sort}" {if $sort eq $selected_menu->items['items'][$subItemId]['sort']} selected {/if}>
                                  {$sort}
                                </option>
                              {/for}
                            </select>
                          </div>
                        </li>
                      {/foreach}
                    </ol>
                  {/if}
                </li>
      		    {/foreach}
            </ol>
          </div>
        </div>
        <div id="button-wrapper">
          <p class="submit">
            <input type="submit" value="Cancel" id="cancel" name="submit">
            &nbsp;
            <input type="submit" value="Update" id="submit" name="submit">
          </p>
        </div>
      </div>
    </form>
    
  </div>  
</div>
  
<link href="{$site_root_path}admin/assets/css/nestable.css" type="text/css" rel="stylesheet">
<script src="{$site_root_path}admin/assets/js/jquery.nestable.js"></script>
<script>
$(document).ready(function() {
  // Hide select lists for JS users
  $('.dd-sort').hide();
  
  // Initiate nestable drag & drop with a max depth of 2
  $('.dd').nestable({
    maxDepth: 2
  }).on('change', function() {
    // On change is triggered each time a menu item has been moved
    // so we fetch the items in a serialized json array and loop through it.
    var items = $(this).nestable('serialize');
    for(var i = 0; i < items.length; i++) {
      // Set the sort number and parent id of the root menu items
      var item = items[i];
      $("select[name='sort-" + item.id + "']").val(i);
      $("select[name='parent-" + item.id + "']").val(0);

      // Find any children and set the sort number and parent id of the menu items
      var children = item.children;
      if(children != undefined) {
        for(var j = 0; j < children.length; j++) {
          var child = children[j];
          $("select[name='sort-" + child.id + "']").val(j);
          $("select[name='parent-" + child.id + "']").val(item.id);
        }
      }
    }
  })
});
</script>

{include file="_footer.tpl"}
