<?php
/**
 * Hackademic-CMS/admin/mode/class.MenuBackend.php
 *
 * Hackademic Menu Backend Model
 * This class extends the functionality of Menu class adding functions specifically
 * required for backend to be able to add, update and delete menu items.
 *
 * Copyright (c) 2013 OWASP
 *
 * LICENSE:
 *
 * This file is part of Hackademic CMS
 * (https://www.owasp.org/index.php/OWASP_Hackademic_Challenges_Project).
 *
 * Hackademic CMS is free software: you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 2 of the License, or (at your option) any later
 * version.
 *
 * Hackademic CMS is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
 * PARTICULAR PURPOSE.  See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * Hackademic CMS.  If not, see <http://www.gnu.org/licenses/>.
 *
 * PHP Version 5.
 *
 * @author    Daniel Kvist <daniel@danielkvist.net>
 * @copyright 2013 OWASP
 * @license   GNU General Public License http://www.gnu.org/licenses/gpl.html
 */
require_once HACKADEMIC_PATH . "model/common/class.HackademicDB.php";
require_once HACKADEMIC_PATH . "model/common/class.Menu.php";
class MenuBackend extends Menu
{

    /**
   * Adds a menu with the given name.
   *
   * @param string $name the name of the menu such as 'My menu'
   *
   * @return true if added
   */
    public static function addMenu($name)
    {
        global $db;
        $params = array(':name' => $name);
        $sql = "INSERT INTO menus(name) VALUES (:name)";
        $query = $db->create($sql, $params, self::$action_type);
        if ($db->affectedRows($query)) {
            return true;
        } else {
            return false;
        }
    }
  
    /**
   * Gets all menus from the database
   *
   * @return an array of menus
   */
    public static function getMenus()
    {
        global $db;
        $sql = "SELECT * FROM menus";
        $result = $db->read($sql, null, self::$action_type);
        $menus = array();
        while ($menu = $db->fetchArray($result)) {
            $menus[] = $menu;
        }
        return $menus;
    }

    /**
   * Updates the menu with the given menu id to the given name.
   *
   * @param id     $mid  menu id of the menu to update
   * @param string $name the new name of the menu such as 'My new menu'
   *
   * @return true if updated
   */
    public static function updateMenu($mid, $name)
    {
        global $db;
        $params = array(
        ':mid' => $mid,
        ':name' => $name
        );
        $sql = "UPDATE menus set name = :name WHERE mid = :mid";
        $query = $db->update($sql, $params, self::$action_type);
        if ($db->affectedRows($query)) {
            return true;
        } else {
            return false;
        }
    }

    /**
   * Deletes the menu with the given menu id.
   *
   * @param id $mid menu id of the menu to delete
   *
   * @return true if deleted
   */
    public static function deleteMenu($mid)
    {
        global $db;
        $params = array(':mid' => $mid);
        $sql = "DELETE from menus WHERE mid = :mid";
        $query = $db->delete($sql, $params, self::$action_type);
        if ($db->affectedRows($query)) {
            return true;
        } else {
            return false;
        }
    }
  
    /**
   * Adds a menu item to the menu with the given menu id. The menu item
   * needs a url to point to, a label to display and a integer to sort on.
   *
   * @param string   $url    the url for the menu item
   * @param id       $mid    the menu id that the menu item belongs to
   * @param string   $label  the label for the menu item that is visible to the user
   * @param integer  $parent the parent menu item id if there is one, otherwise 0 if 
   *                         root item
   * @param interger $sort   the sort integer for the menu item, sort is made
   *                         ascending
   *
   * @return true if added
   */
    public static function addMenuItem($url, $mid, $label, $parent, $sort)
    {
        global $db;
    
        $params = array(
         ':url' => $url,
         ':mid' => $mid,
        ':label' => $label,
            ':parent' => $parent,
        ':sort' => $sort
        );
    
        $sql = "INSERT INTO menu_items(url, mid, label, parent, sort) VALUES (:url, :mid, :label, :parent, :sort)";
        $query = $db->create($sql, $params, self::$action_type);
        if ($db->affectedRows($query)) {
            return true;
        } else {
            return false;
        }
    }

    /**
   * Updates a menu item to the menu with the given menu id. The menu item
   * needs a url to point to, a label to display and a integer to sort on.
   *
   * @param string  $url    the url for the menu item
   * @param id      $mid    the menu id that the menu item belongs to
   * @param string  $label  the new label for the menu item that is visible to the
   *                        user
   * @param integer $parent the parent menu item id if there is one, otherwise 0 if
   *                        root item
   * @param integer $sort   the new sort integer for the menu item, sort is made
   *                        ascending
   *
   * @return true if updated
   */
    public static function updateMenuItem($url, $mid, $label, $parent, $sort)
    {
        global $db;
    
        $params = array(
         ':url' => $url,
        ':mid' => $mid,
        ':label' => $label,
            ':parent' => $parent,
        ':sort' => $sort
         );

        $sql = "UPDATE menu_items SET label = :label, parent = :parent, sort = :sort WHERE url = :url AND mid = :mid";
        $query = $db->update($sql, $params, self::$action_type);
        if ($db->affectedRows($query)) {
            return true;
        } else {
            return false;
        }
    }

    /**
   * Deletes a menu item to the menu with the given menu id.
   *
   * @param string $url the url for the menu item
   * @param id     $mid the menu id that the menu item belongs to
   *
   * @return true if deleted
   */
    public static function deleteMenuItem($url, $mid)
    {
        global $db;
    
        $params = array(
            ':url' => $url,
            ':mid' => $mid
        );
    
        $sql = "DELETE FROM menu_items WHERE url = :url AND mid = :mid";
        $query = $db->delete($sql, $params, self::$action_type);
        if ($db->affectedRows($query)) {
            return true;
        } else {
            return false;
        }
    }
  
    /**
   * Gets the row id of the lastly inserted row in the database.
   *
   * @return the last inserted id
   */
    public static function insertId()
    {
        global $db;
        return $db->insertId();
    }

}
