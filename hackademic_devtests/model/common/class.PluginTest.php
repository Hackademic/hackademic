<?php

/**
 * Hackademic-CMS/test/model/common/class.PluginTest.php
 *
 * Hackademic Plugin Class Test
 * Class for Testing Hackademic's Plugin API
 *
 * This class  plugin API that 3rd party plugins can use to add actions and filters
 * that the Hackademic core executes.
 *
 * The whole class is based on the Wordpress Plugin API (http://codex.wordpress.org/Plugin_API/)
 * with very few modifications to suit the Hackademic Challenges Project.
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


class PluginTest extends PHPUnit_Framework_TestCase {

    public function setUp(){
        global $db;
        $db = new HackademicDB();
        Loader::init();
        require_once('model/common/class.Plugin.php');
    }
    public function tearDown(){ }

    /**
     * Loads the plugins and then tests if all plugins that are in the database have been loaded.
     */
    public function test_load_plugins() {
        Plugin::loadPlugins();

        $active_plugins = Options::getOption('active_plugins')->value;
        foreach($active_plugins as $plugin) {
            assert(in_array($plugin, $active_plugins));
        }
    }

    /**
     * Tests adding a filter with default values
     */
    public function test_add_filter_defaults() {
        global $hc_filter;
        $tag = 'test_filter';
        $function_name = 'test_test_filter';
        $priority = 10;
        $args = 1;

        Plugin::add_filter($tag, $function_name);

        $this->assertTrue($hc_filter[$tag][$priority][$function_name]['function'] == $function_name);
        $this->assertTrue($hc_filter[$tag][$priority][$function_name]['accepted_args'] == $args);
        unset($hc_filter[$tag]);
    }

    /**
     * Tests adding a filter with prio 5 and 2 arguments
     */
    public function test_add_filter_5_prio_2_args() {
        global $hc_filter;
        $tag = 'test_filter';
        $function_name = 'test_test_filter';
        $priority = 5;
        $args = 2;

        Plugin::add_filter($tag, $function_name, $priority, $args);
        $this->assertTrue($hc_filter[$tag][$priority][$function_name]['function'] == $function_name);
        $this->assertTrue($hc_filter[$tag][$priority][$function_name]['accepted_args'] == $args);
        unset($hc_filter[$tag]);
    }

    /**
     * Makes sure that trying to get an action with a different prio doesn't work
     */
    public function test_add_filter_custom_prio_failure() {
        global $hc_filter;
        $tag = 'test_filter';
        $function_name = 'test_test_filter';
        $priority = 5;

        Plugin::add_filter($tag, $function_name);
        try {
            $fail = $hc_filter[$tag][$priority];
            $this->fail('Wrong prio, got value: ' . $fail);
        } catch (Exception $e) {
            // Success!
        }
        unset($hc_filter[$tag]);
    }

    /**
     * Tries to apply filters and makes sure the first argument is returned
     */
    public function test_apply_filters_ref_array_no_filters() {
        $args = array(1, 2);
        $this->assertTrue(Plugin::apply_filters_ref_array('no_tag', $args) === 1);
    }

    /**
     * Applies filter to one function and one argument and makes sure the
     * text is filtered properly.
     */
    public function test_apply_filters_ref_array_one_function_one_arg() {
        global $hc_filter;

        $tag = 'test_filter';
        $function_name = 'test_test_filter';
        $arg0 = "arg0";

        Plugin::add_filter($tag, $function_name);
        $filtered_arg = Plugin::apply_filters_ref_array($tag, array($arg0));

        $this->assertTrue($filtered_arg == "filtered: " . $arg0);
        unset($hc_filter[$tag]);
    }

    /**
     * Applies filter to one function and two arguments and makes sure the
     * text is filtered properly.
     */
    public function test_apply_filters_ref_array_one_function_two_args() {
        global $hc_filter;

        $tag = 'test_filter';
        $function_name = 'test_test_filter_2';
        $arg0 = "arg0";
        $arg1 = "arg1";
        $priority = 10;
        $args = 2;

        Plugin::add_filter($tag, $function_name, $priority, $args);
        $filtered_arg = Plugin::apply_filters_ref_array($tag, array($arg0, $arg1));

        $this->assertTrue($filtered_arg == "filtered: " . $arg0 . $arg1);
        unset($hc_filter[$tag]);
    }

    /**
     * Applies filter to two separate functions with different prio and
     * makes sure the prio sorting works as expected.
     */
    public function test_apply_filters_ref_array_two_functions_prio() {
        global $hc_filter;

        $tag = 'test_filter';
        $function_name1 = 'test_test_filter_prio_1';
        $function_name2 = 'test_test_filter_prio_2';
        $priority1 = 1;
        $priority2 = 2;
        $args = 0;

        Plugin::add_filter($tag, $function_name1, $priority1, $args);
        Plugin::add_filter($tag, $function_name2, $priority2, $args);

        $filtered_arg = Plugin::apply_filters_ref_array($tag, array());
        $this->assertTrue($filtered_arg == "prio2");
        unset($hc_filter[$tag]);
    }

    /**
     * Test to make sure a specific function is removed from a tag.
     */
    public function test_remove_filter() {
        global $hc_filter;

        $tag = 'test_filter';
        $function_name = 'test_test_filter';

        Plugin::add_filter($tag, $function_name);

        $this->assertTrue(!empty($hc_filter[$tag]));

        Plugin::remove_filter($tag, $function_name);

        $this->assertTrue(empty($hc_filter[$tag]));
    }

    /**
     * Tests removing all functions from a  tag.
     */
    public function test_remove_all_filters() {
        global $hc_filter;

        $tag = 'test_filter';
        $function_name1 = 'test_test_filter';
        $function_name2 = 'test_test_filter_2';

        Plugin::add_filter($tag, $function_name1);
        Plugin::add_filter($tag, $function_name2);

        $this->assertTrue(!empty($hc_filter[$tag]));

        Plugin::remove_all_filters($tag);

        $this->assertTrue(empty($hc_filter[$tag]));
    }

    /**
     * Test add action defaults.
     */
    public function test_add_action_defaults() {
        global $hc_filter;
        $tag = 'test_action';
        $function_name = 'test_test_filter';
        $priority = 10;
        $args = 1;

        Plugin::add_action($tag, $function_name);

        $this->assertTrue($hc_filter[$tag][$priority][$function_name]['function'] == $function_name);
        $this->assertTrue($hc_filter[$tag][$priority][$function_name]['accepted_args'] == $args);
        unset($hc_filter[$tag]);
    }

    /**
     * Test performing an action with one function and one argument.
     */
    public function test_do_action_ref_array_one_function_one_arg() {
        global $hc_filter, $action;

        $action = "arg";
        $tag = 'test_action';
        $function_name = 'test_test_action';
        $arg0 = "arg0";

        Plugin::add_action($tag, $function_name);
        Plugin::do_action_ref_array($tag, array($arg0));
        $this->assertTrue($action == $arg0);
        unset($hc_filter[$tag]);
    }

    /**
     *  Test performing an action with multiple arguments
     */
    public function test_do_action_ref_array_one_function_two_args() {
        global $hc_filter, $action;

        $action = "arg";
        $tag = 'test_action';
        $function_name = 'test_test_action_2';
        $priority = 10;
        $args = 2;
        $arg0 = "arg0";
        $arg1 = "arg1";

        Plugin::add_action($tag, $function_name, $priority, $args);
        Plugin::do_action_ref_array($tag, array($arg0, $arg1));
        $this->assertTrue($action == $arg0 . $arg1);
        unset($hc_filter[$tag]);
    }

    /**
     * Test performing actions with different prio.
     */
    public function test_do_action_ref_array_two_functions_prio() {
        global $hc_filter, $action;

        $action = "prio";
        $tag = 'test_action';
        $function_name1 = 'test_test_action_prio_1';
        $function_name2 = 'test_test_action_prio_2';
        $priority1 = 1;
        $priority2 = 2;
        $args = 0;

        Plugin::add_action($tag, $function_name1, $priority1, $args);
        Plugin::add_action($tag, $function_name2, $priority2, $args);

        Plugin::do_action_ref_array($tag, array());
        $this->assertTrue($action == "prio2");
        unset($hc_filter[$tag]);
    }

    /**
     * Test to remove a function from an action.
     */
    public function test_remove_action() {
        global $hc_filter;

        $tag = 'test_action';
        $function_name = 'test_test_action';

        Plugin::add_action($tag, $function_name);

        $this->assertTrue(!empty($hc_filter[$tag]));

        Plugin::remove_action($tag, $function_name);

        $this->assertTrue(empty($hc_filter[$tag]));
    }

    /**
     * Test to remove all functions from an action.
     */
    public function test_remove_all_actions() {
        global $hc_filter;

        $tag = 'test_action';
        $function_name1 = 'test_test_action';
        $function_name2 = 'test_test_action_2';

        Plugin::add_action($tag, $function_name1);
        Plugin::add_action($tag, $function_name2);

        $this->assertTrue(!empty($hc_filter[$tag]));

        Plugin::remove_all_actions($tag);

        $this->assertTrue(empty($hc_filter[$tag]));
    }
    
  
    /**
     * Tests adding a menu
     */
    public static function test_add_menu() {
      global $db;
      $name = 'test_menu';
      $result = Plugin::add_menu($name);
      $db->query('delete from menus where name = "' . $name . '"');
      assert($result === TRUE);
    }
  
    /**
     * Tests retrieving a menu
     */
    public static function test_get_menu() {
      global $db;
      $name = 'test_menu';
      MenuBackend::addMenu($name);
      $mid = MenuBackend::insertId();
      $menu = Plugin::get_menu($mid);
      $db->query('delete from menus where name = "' . $name . '"');
      assert(is_array($menu->items));
      assert(sizeof($menu->items) > 0);
    }
  
    /**
     * Tests updating the menu name
     */
    public static function test_update_menu() {
      global $db;
      $name = 'test_menu';
      $name2 = 'test_menu2';
      MenuBackend::addMenu($name);
      $mid = MenuBackend::insertId();
      $result = Plugin::update_menu($mid, $name2);
      assert($result === TRUE);
    }
  
    /**
     * Tests deleting a menu
     */  
    public static function test_delete_menu() {
      global $db;
      $name = 'test_menu';
      MenuBackend::addMenu($name);
      $mid = MenuBackend::insertId();
      $result = Plugin::delete_menu($mid);
      $db->query('delete from menus where mid = "$mid"');
      assert($result === TRUE);
    }

    /**
     * Tests adding a page
     */
    public static function test_add_page() {
      global $db;
      $url = 'testurl';
      $file = 'testfile';
      $result = Plugin::add_page($url, $file);
      $db->query('delete from pages where url = "' . $url . '"');
      assert($result === TRUE);
    }

    /**
     * Tests retrieving a file for a url
     */
    public static function test_get_file_for_page() {
      global $db;
      $url = 'testurl';
      $file = 'testpage';
      Plugin::add_page($url, $file);
      $result = Plugin::get_file_for_page($url);
      $db->query('delete from pages where url = "' . $url . '"');
      assert($result['file'] === $file);
    }

    /**
     * Tests updating a page
     */
    public static function test_update_page() {
      global $db;
      $url = 'testurl';
      $file = 'testfile';
      $file2 = 'testfile2';
      Plugin::add_page($url, $file);
      $result = Plugin::update_page($url, $file2);
      $db->query('delete from pages where url = "' . $url . '"');
      assert($result === TRUE);
    }

    /**
     * Tests deleting a page
     */
    public static function test_delete_page() {
      global $db;
      $url = 'testurl';
      $file = 'testfile';
      Plugin::add_page($url, $file);
      $result = Plugin::delete_page($url);
      $db->query('delete from pages where url = "' . $url . '"');
      assert($result === TRUE);
    }
  
    /**
     * Tests adding a menu item to an existing menu
     */
  	public static function test_add_menu_item() {
      global $db;
      $url = 'testurl';
      $mid = MenuBackend::ADMIN_MENU;
      $label = 'testlabel';
      $parent = 0;
      $sort = 0;
  	  $result = Plugin::add_menu_item($url, $mid, $label, $parent, $sort);
      $db->query('delete from menu_items where url="' . $url . '" and mid="$mid"');
      assert($result === TRUE);
  	}
  
    /**
     * Tests updating an existing menu item
     */
  	public static function test_update_menu_item() {
      global $db;
      $url = 'testurl';
      $mid = MenuBackend::ADMIN_MENU;
      $label = 'testlabel';
      $label2 = 'updated-testlabel';
      $parent = 0;
      $sort = 0;
      MenuBackend::addMenuItem($url, $mid, $label, $parent, $sort);
      $result = Plugin::update_menu_item($url, $mid, $label2, $parent, $sort);
      $db->query('delete from menu_items where url="' . $url . '" and mid="$mid"');
      assert($result === TRUE);
  	}
  
    /**
     * Tests deleting a menu item
     */
  	public static function test_delete_menu_item() {
      global $db;
      $url = 'testurl';
      $mid = MenuBackend::ADMIN_MENU;
      $label = 'testlabel';
      $parent = 0;
      $sort = 0;
      MenuBackend::addMenuItem($url, $mid, $label, $parent, $sort);
  	  $result = Plugin::delete_menu_item($url, $mid);
      $db->query('delete from menu_items where url="' . $url . '" and mid="$mid"');
      assert($result === TRUE);
  	}

}

/**
 *
 * Helper functions to test that are executed by the Plugin API below
 *
 */

function test_test_filter($arg0) {
    return "filtered: " . $arg0;
}

function test_test_filter_2($arg0, $arg1) {
    return "filtered: " . $arg0 . $arg1;
}

function test_test_filter_prio_1() {
    return "prio1";
}

function test_test_filter_prio_2() {
    return "prio2";
}

function test_test_action($arg0) {
    global $action;
    $action = $arg0;
}

function test_test_action_2($arg0, $arg1) {
    global $action;
    $action = $arg0 . $arg1;
}

function test_test_action_prio_1() {
    global $action;
    $action = "prio1";
}

function test_test_action_prio_2() {
    global $action;
    $action = "prio2";
}
