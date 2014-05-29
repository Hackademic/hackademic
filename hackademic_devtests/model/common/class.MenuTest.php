<?php

/**
 * Hackademic-CMS/test/model/common/class.MenuTest.php
 *
 * Hackademic Menu Class Test
 * Class for Testing Hackademic's Menu mapping
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
 * @author Daniel Kvist <daniel[at]danielkvist[dot]net>
 * @license http://www.gnu.org/licenses/gpl.html
 * @copyright 2013 OWASP
 *
 */

require_once("config.inc.php");
require_once("model/common/class.Loader.php");
require_once("model/common/class.HackademicDB.php");


class MenuTest extends PHPUnit_Framework_TestCase {

    public function setUp() {
        global $db;
        $db = new HackademicDB();
        Loader::init();
        require_once('model/common/class.Menu.php');
    }
    public function tearDown(){ }

    /**
     * Tries to fetch the admin menu and makes sure it has an array of
     * items that is not empty.
     */
    public function test_get_admin_menu() {
      $menu = Menu::getMenu(Menu::ADMIN_MENU);
      assert(is_array($menu->items));
      assert(sizeof($menu->items) > 0);
    }
    
    /**
     * Tries to fetch the admin menu and makes sure it has an array of
     * items that is not empty and that contains parents and children
     * in a correct way that respects the menu hierarchy.
     */
    public function test_get_admin_menu_with_parent_and_child_items() {
      global $db;
      $url = 'testurl';
      $file = 'testfile';
      $url2 = 'testurl2';
      $file2 = 'testfile2';
      
      $db->query('insert into pages (url, file) values ("' . $url . '", "' . $file . '")');
      $db->query('insert into pages (url, file) values ("' . $url2 . '", "' . $file2 . '")');
      $db->query('insert into menu_items (url, mid, label, parent, sort) values ("' . $url . '", ' . Menu::ADMIN_MENU . ', "testlabel",  0, 0)');
      $parent_id = $db->insertId();
      $db->query('insert into menu_items (url, mid, label, parent, sort) values ("' . $url2 . '",' . Menu::ADMIN_MENU . ', "testlabel2",  ' . $parent_id . ', 0)');
      $child_id = $db->insertId();
      $menu = Menu::getMenu(Menu::ADMIN_MENU);
      
      $db->query("delete from menu_items where url = '" . $url . "'");
      $db->query("delete from menu_items where url = '" . $url2 . "'");      
      $db->query("delete from pages where url = '" . $url . "'");
      $db->query("delete from pages where url = '" . $url2 . "'");
      
      assert(is_array($menu->items));
      assert(sizeof($menu->items) > 0);
      assert($parent_id > 0);
      assert($child_id > 0);
      assert(is_array($menu->items['parents'][$parent_id]));
      assert($menu->items['parents'][$parent_id][0] == $child_id);
    }
    
    /**
     * Tries to fetch the teacher menu and makes sure it has an array of
     * items that is not empty.
     */
    public function test_get_teacher_menu() {
      $menu = Menu::getMenu(Menu::TEACHER_MENU);
      assert(is_array($menu->items));
      assert(sizeof($menu->items) > 0);
    }
    
    /**
     * Tries to fetch the student menu and makes sure it has an array of
     * items that is not empty.
     */
    public function test_get_student_menu() {
      $menu = Menu::getMenu(Menu::STUDENT_MENU);
      assert(is_array($menu->items));
      assert(sizeof($menu->items) > 0);
    }
}
