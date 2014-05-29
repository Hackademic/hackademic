<?php

/**
 * Hackademic-CMS/test/admin/model/class.MenuBackendTest.php
 *
 * Hackademic Menu Backend Class Test
 * Class for Testing Hackademic's Menu Backend model
 *
 * LICENSE:
 *
 * This file is part of Hackademic CMS (https://www.owasp.org/index.php/OWASP_Hackademic_Challenges_Project).
 *
 * Hackademic CMS is free software: you can redistribute it and/or modify it under the terms of the GNU General Public
 * License as published by the Free Software Foundation, either version 2 of the License, or (at your page) any
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

class MenuBackendTest extends PHPUnit_Framework_TestCase {

  public static $name = 'testname';
  public static $url = 'testurl';
  public static $file = 'testfile';
  public static $mid = 1;
  public static $label = 'testlabel';
  public static $parent = 0;
  public static $sort = 0;

  /**
   * Sets up a db connection and initiates the required constants that are needed
   * for the tests and includes.
   */
  public function setUp() {
    global $db;
    $db = new HackademicDB();
    Loader::init();
    require_once('admin/model/class.MenuBackend.php');
  }

  public function tearDown() { }

  /**
   * Tests that the addMenu function actually inserts a value into the database.
   */
  public function test_add_menu_return_true() {
    global $db;

    $result = MenuBackend::addMenu(self::$name);
    $mid = MenuBackend::insertId();
    $result_set = $db->query("select * from menus where mid = '" . $mid . "'");
    $row = $db->fetchArray($result_set);
    $db->query("delete from menus where mid = '" . $mid . "'");

    assert($result === true);
    assert($mid > 0);
    assert($row['mid'] == $mid);
    assert($row['name'] == self::$name);
  }

  /**
   * Tests the updateOption to make sure the menu name is updated.
   */
  public function test_update_existing_menu_return_true() {
    global $db;

    $update_value = self::$file . '_updated';
    MenuBackend::addMenu(self::$name);
    $mid = MenuBackend::insertId();
    $result = MenuBackend::updateMenu($mid, $update_value);
    $result_set = $db->query("select * from menus where mid = '" . $mid . "'");
    $row = $db->fetchArray($result_set);
    $db->query("delete from menus where mid = '" . $mid . "'");

    assert($result === true);
    assert($row['mid'] == $mid);
    assert($row['name'] == $update_value);
  }

  /**
   * Tests deleting a menu
   */
  public static function test_delete_menu_return_true() {
    global $db;
    $name = 'test_menu';
    MenuBackend::addMenu($name);
    $mid = MenuBackend::insertId();
    $result = MenuBackend::deleteMenu($mid);
    $db->query('delete from menus where mid = "$mid"');
    assert($result === TRUE); 
  }

  /**
   * Tests the return statement of trying to update a non-existing menu.
   */
  public function test_update_non_existing_menu_return_false() {
    $non_existing_mid = 99999;
    $result = MenuBackend::updateMenu($non_existing_mid, self::$name);
    assert($result === false);
  }
  
  /**
   * Tries to add a menu item with a corresponding page and makes sure they are
   * added and can be fetched.
   */
  public function test_add_menu_item_return_true() {
    global $db;

    $db->query('insert into pages (url, file) values ("' . self::$url . '", "' . self::$file . '")');
    $result = MenuBackend::addMenuItem(self::$url, self::$mid, self::$label, self::$parent, self::$sort);
    $result_set = $db->query("select * from menu_items where url = '" . self::$url . "' AND mid = " . self::$mid);
    $row = $db->fetchArray($result_set);
    $db->query('delete from menu_items where url = "' . self::$url . '" AND mid = ' . self::$mid);
    $db->query('delete from pages where url = "' . self::$url . '"');

    assert($result === true);
    assert($row['url'] == self::$url);
    assert($row['mid'] == self::$mid);
    assert($row['label'] == self::$label);
    assert($row['parent'] == self::$parent);
    assert($row['sort'] == self::$sort);
  }
  
  /**
   * Tries to update a menu item with a corresponding page and makes sure they are
   * updated and can be fetched.
   */
  public function test_update_menu_item_return_true() {
    global $db;
    
    $updated_label = self::$label . '_updated';
    $updated_sort = 10;
    $updated_parent = 1;
    
    $db->query('insert into pages (url, file) values ("' . self::$url . '", "' . self::$file . '")');
    MenuBackend::addMenuItem(self::$url, self::$mid, self::$label, self::$parent, self::$sort);
    $result = MenuBackend::updateMenuItem(self::$url, self::$mid, $updated_label, $updated_parent, $updated_sort);
    $result_set = $db->query("select * from menu_items where url = '" . self::$url . "' AND mid = " . self::$mid);
    $row = $db->fetchArray($result_set);
    $db->query('delete from menu_items where url = "' . self::$url . '" AND mid = ' . self::$mid);
    $db->query('delete from pages where url = "' . self::$url . '"');

    assert($result === true);
    assert($row['url'] == self::$url);
    assert($row['mid'] == self::$mid);
    assert($row['label'] == $updated_label);
    assert($row['parent'] == $updated_parent);
    assert($row['sort'] == $updated_sort);
  }
  
  /**
   * Tries to delete a menu item and makes sure it's deleted.
   */
  public function test_delete_menu_item_return_true() {
    global $db;

    $db->query('insert into pages (url, file) values ("' . self::$url . '", "' . self::$file . '")');
    MenuBackend::addMenuItem(self::$url, self::$mid, self::$label, self::$parent, self::$sort);
    $result = MenuBackend::deleteMenuItem(self::$url, self::$mid);
    $result_set = $db->query("select * from menu_items where url = '" . self::$url . "' AND mid = " . self::$mid);
    $row = $db->fetchArray($result_set);
    $db->query('delete from pages where url = "' . self::$url . '"');

    assert($result === true);
    assert(empty($row) === true);
  }

}