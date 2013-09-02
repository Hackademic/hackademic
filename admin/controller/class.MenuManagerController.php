<?php
/**
 *
 * Hackademic-CMS/admin/controller/class.MenuManagerController.php
 *
 * Hackademic Backend Menu Manager Controller
 * Class for managing the menus
 *
 * Copyright (c) 2013 OWASP
 *
 * LICENSE:
 *
 * This file is part of Hackademic CMS (https://www.owasp.org/index.php/OWASP_Hackademic_Challenges_Project).
 *
 * Hackademic CMS is free software: you can redistribute it and/or modify it under the terms of the GNU General Public
 * License as published by the Free Software Foundation, either version 2 of the License, or (at your option) any
 * later version.
 *
 * Hackademic CMS is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
 * details.
 *
 * You should have received a copy of the GNU General Public License along with Hackademic CMS.  If not, see
 * <http://www.gnu.org/licenses/>.
 *
 *
 * @author Daniel Kvist <daniel[at]danielkvist[dot]net>
 * @license http://www.gnu.org/licenses/gpl.html
 * @copyright 2013 OWASP
 *
 */

require_once(HACKADEMIC_PATH . "admin/controller/class.HackademicBackendController.php");
require_once(HACKADEMIC_PATH . "admin/model/class.MenuBackend.php");
require_once(HACKADEMIC_PATH . "admin/model/class.PageBackend.php");

class MenuManagerController extends HackademicBackendController {
  
  private static $action_type = 'menu_manager';

	public function go() {
    $menus = MenuBackend::getMenus();
    $submit = isset($_POST['submit']) ? $_POST['submit'] : '';
    
    if($submit == 'Cancel' || empty($submit)) {
      $menu = Menu::getMenu(Menu::ADMIN_MENU);
    } else if($submit == 'Change') {
      $menu = Menu::getMenu($_POST['menu']);
    } else if($submit == 'Update') {
      // Get the menu that has been shown (can be different from the selected menu)
      $menu = Menu::getMenu($_POST['mid']);
      
      // Loop through all post vars to find the parent inputs so
      // that we can split them and use the id from the name. Once
      // we have the id, we can fetch the old item from the database
      // and make any changes we wish.
      foreach($_POST as $key => $value) {
        $is_parent = substr($key, 0, 6) == 'parent';

        // When we have a parent we can get the id which is the same for the parent and
        // sort select lists.
        if($is_parent) {
          $pieces = explode('-', $key);
          $id = $pieces[1];
          $menu_item = $menu->items['items'][$id];
          
          // Make sure the selected menu is the same as the menu that was shown
          if($menu_item['mid'] == $_POST['menu']) {
            
            // Make sure a child is not parent to its own parent
            if(isset($_POST['parent-' . $value]) && $id == $_POST['parent-' . $value]) {
              $this->addErrorMessage("A child element cannot be parent to its own parent.");
            }
             
            // If we have new and valid data, lets store it in the database
            else if($menu_item['parent'] != $value || $menu_item['sort'] != $_POST['sort-' . $id]) {
              $menu_item['parent'] = $value;
              $menu_item['sort'] = $_POST['sort-' . $id];
              MenuBackend::updateMenuItem($menu_item['url'], $menu_item['mid'], $menu_item['label'], $menu_item['parent'], $menu_item['sort']);
              $this->addSuccessMessage("Menu items has been updated.");
            }
          }
          
          // The user selected another menu and tried to update items without first submitting the change of menu
          else {
            $this->addErrorMessage("The selected menu did not correspond to the items you where editing. Did you remember to change the active menu?");
          }
        }
      }
      
      // We have saved all item changes if any, lets fetch a fresh menu from the database to make sure we get
      // the structure in the way we want it in the template.
      $menu = Menu::getMenu($_POST['menu']);
    }

    $this->addToView('menus', $menus);
    $this->addToView('selected_menu', $menu);
    $this->addToView('main_menu_admin', Menu::getMenu(Menu::ADMIN_MENU)->items);
		$this->setViewTemplate('menumanager.tpl');
		$this->generateView(self::$action_type);
	}
}
