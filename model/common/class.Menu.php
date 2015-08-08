<?php
/**
 * Hackademic-CMS/model/common/class.Menu.php
 *
 * Hackademic Menu class
 * Class for Hackademic's Menu Object
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

class Menu
{
  
  const ADMIN_MENU = 1;
  const TEACHER_MENU = 2;
  const STUDENT_MENU = 3;
    
  protected static $action_type = 'menu';
  public $items;

  /**
   * Retrives the menu for the given menu id
   * 
   * @param id $mid the id of the menu to load
   *
   * @return an array with the menu items
   */
  public static function getMenu($mid)
  {
    global $db;

    $params = array(':mid' => $mid);
    $sql = "SELECT * FROM menu_items WHERE mid = :mid ORDER BY parent, sort, label";

    $result_set = $db->read($sql, $params, self::$action_type);
    
    $menu = new self;
    $menu->items = self::buildMenu($result_set);
    $menu->mid = $mid;

    return $menu;
  }
  
  /**
   * Builds the menu from the result set
   * 
   * @param Array $result_set the result from the database
   *
   * @return the structured array of menu items
   */
  private static function buildMenu($result_set)
  {
    global $db;

    $menu = array(
      'items' => array(),
      'parents' => array()
    );

    while ($items = $db->fetchArray($result_set)) {
      $menu['items'][$items['id']] = $items;
      $menu['parents'][$items['parent']][] = $items['id'];
    }

    return $menu;
  }

}
