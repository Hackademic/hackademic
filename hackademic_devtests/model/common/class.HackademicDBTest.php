<?php

/**
 * Hackademic-CMS/test/model/common/class.HackademicDBTest.php
 *
 * Hackademic HackademicDB Class Test
 * Class for Testing Hackademic's Plugin API CRUD operations
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


global $before_called, $after_called, $db;
require_once ("../../../model/common/class.Loader.php");
require_once ("../../../config.inc.php");
require_once ("../../../model/common/class.HackademicDB.php");
class HackademicDBTest extends PHPUnit_Framework_TestCase {

	private $test_name = 'test_name';
	private $test_value = 'test_value';
	private $test_value2 = 'test_value2';

	private static $action_type = 'test';

	/**
	 * Sets up the database connection and resets the instance variables
	 * that keeps track of if an action was triggered successfully or not.
	 */
	public function setUp() {
		global $db, $before_called, $after_called;
		$db = new HackademicDB();
		Loader::init();
		require_once (HACKADEMIC_PATH."model/common/class.HackademicDB.php");
		require_once (HACKADEMIC_PATH.'model/common/class.Plugin.php');
	}

	/**
	 * Tests the 'before_create' and 'after_create' actions that are triggered
	 * when data is being inserted into the database using the 'create' function.
	 */
	public function test_before_and_after_action_on_create() {
		global $db, $before_called, $after_called;

		Plugin::add_action('before_create_test', 'test_before_two_params', 10, 2);
		Plugin::add_action('after_create_test', 'test_after_two_params', 10, 2);

		$sql = "INSERT INTO options(option_name, option_value) ";
		$sql .= "VALUES (:option_name, :option_value)";
		$params = array(':option_name' => $this -> test_name, ':option_value' => $this -> test_value);
		$db -> create($sql, $params, self::$action_type);

		assert($before_called === TRUE);
		assert($after_called === TRUE);
	}

	/**
	 * Tests the 'before_read' and 'after_read' actions that are triggered
	 * when data is being read from the database using the 'read' function.
	 */
	public function test_before_and_after_action_on_read() {
		global $db, $before_called, $after_called;

		Plugin::add_action('before_read_test', 'test_before_two_params', 10, 2);
		Plugin::add_action('after_read_test', 'test_after_one_param', 10, 1);

		$sql = "INSERT INTO options(option_name, option_value) ";
		$sql .= "VALUES (:option_name, :option_value)";
		$params = array(':option_name' => $this -> test_name, ':option_value' => $this -> test_value);
		$db -> query($sql, $params);

		$sql = "SELECT * FROM options WHERE option_name = :option_name";
		$params = array(':option_name' => $this -> test_name);
		$db -> read($sql, $params, self::$action_type);

		assert($before_called === TRUE);
		assert($after_called === TRUE);
	}

	/**
	 * Tests the 'before_update' and 'after_update' actions that are triggered
	 * when data is being updated in the database using the 'update' function.
	 */
	public function test_before_and_after_action_on_update() {
		global $db, $before_called, $after_called;

		Plugin::add_action('before_update_test', 'test_before_two_params', 10, 2);
		Plugin::add_action('after_update_test', 'test_after_one_param', 10, 1);

		$sql = "INSERT INTO options(option_name, option_value) ";
		$sql .= "VALUES (:option_name, :option_value)";
		$params = array(':option_name' => $this -> test_name, ':option_value' => $this -> test_value);
		$db -> query($sql, $params);

		$sql = "UPDATE options SET option_value = :option_value WHERE option_name = :option_name";
		$params = array(':option_name' => $this -> test_name, ':option_value' => $this -> test_value2);
		$db -> update($sql, $params, self::$action_type);

		assert($before_called === TRUE);
		assert($after_called === TRUE);
	}

	/**
	 * Tests the 'before_delete' and 'after_delete' actions that are triggered
	 * when data is being deleted from the database using the 'delete' function.
	 */
	public function test_before_and_after_action_on_delete() {
		global $db, $before_called, $after_called;

		Plugin::add_action('before_delete_test', 'test_before_two_params', 10, 2);
		Plugin::add_action('after_delete_test', 'test_after_one_param', 10, 1);

		$sql = "INSERT INTO options(option_name, option_value) ";
		$sql .= "VALUES (:option_name, :option_value)";
		$params = array(':option_name' => $this -> test_name, ':option_value' => $this -> test_value);
		$db -> query($sql, $params);

		$sql = "DELETE FROM options WHERE option_name = :option_name";
		$params = array(':option_name' => $this -> test_name);
		$db -> delete($sql, $params, self::$action_type);

		assert($before_called === TRUE);
		assert($after_called === TRUE);
	}

	/**
	 * Deletes the option from the database after each test to make sure
	 * the tests run independently. Also closes the db connection.
	 */
	public function tearDown() {
		global $db;
		$sql = "DELETE FROM options WHERE option_name = :option_name";
		$params = array(':option_name' => $this -> test_name);
		$db -> query($sql, $params);
		$db -> closeConnection();
		$db = NULL;
	}

	public function test_read() {
		global $db;

		$sql = "INSERT INTO options(option_name, option_value) ";
		$sql .= "VALUES (:option_name, :option_value)";
		$params = array(':option_name' => $this -> test_name, ':option_value' => $this -> test_value);
		$db -> query($sql, $params);
		
		$this->assert_in_db("option_name", $this->test_name, "options");
	}
	
	public function test_update(){
		global $db;

		$sql = "INSERT INTO options(option_name, option_value) ";
		$sql .= "VALUES (:option_name, :option_value)";
		$params = array(':option_name' => $this -> test_name, ':option_value' => $this -> test_value);
		$db -> query($sql, $params);

		$sql = "UPDATE options SET option_value = :option_value WHERE option_name = :option_name";
		$params = array(':option_name' => $this -> test_name, ':option_value' => $this -> test_value2);
		$db -> update($sql, $params, self::$action_type);
		
		$this->assert_in_db("option_name", $this->test_name, "options");
		
	}
	public function test_delete(){
		global $db;
		
		$sql = "INSERT INTO options(option_name, option_value) ";
		$sql .= "VALUES (:option_name, :option_value)";
		$params = array(':option_name' => $this -> test_name, ':option_value' => $this -> test_value);
		$db -> query($sql, $params);

		$sql = "DELETE FROM options WHERE option_name = :option_name";
		$params = array(':option_name' => $this -> test_name);
		$db -> delete($sql, $params, self::$action_type);
		$this->assert_not_in_Db("option_name", $this->test_name, "options");
	}
	public function test_create(){
		global $db;

		$sql = "INSERT INTO options(option_name, option_value) ";
		$sql .= "VALUES (:option_name, :option_value)";
		$params = array(':option_name' => $this -> test_name, ':option_value' => $this -> test_value);
		$db -> create($sql, $params,self::$action_type);
		$this->assert_in_Db("option_name", $this->test_name, "options");
	}
	private function assert_not_in_Db($field,$val,$table){
		global $db;

		$sql = "SELECT * FROM $table WHERE $field=:val";
		$params = array(':val' => $val);
		
		$rs = $db->query($sql, $params, self::$action_type);
		$result = $db->fetchArray($rs);
		assert(empty($result));
	}
	private function assert_in_Db($field,$val,$table){
		global $db;

		$sql = "SELECT * FROM $table WHERE $field=:val";
		$params = array(':val' => $val);
		
		$rs = $db->query($sql, $params, self::$action_type);
		$result = $db->fetchArray($rs);
		assert( $result[$field] === $val );
	}
}
	/**
	 * Runs when the plugin api triggers a 'before' action with two params.
	 *
	 * @param $sql
	 * @param $params
	 */
	function test_before_two_params($sql, $params) {
		global $before_called;
		$before_called = TRUE;
	}

	/**
	 * Runs when the plugin api triggers an 'after' action with one param.
	 *
	 * @param $params
	 */
	function test_after_one_param($params) {
		global $after_called;
		$after_called = TRUE;
	}

	/**
	 * Runs when the plugin api triggers a 'after' action with two params.
	 *
	 * @param $id
	 * @param $params
	 */
	function test_after_two_params($id, $params) {
		global $after_called;
		$after_called = TRUE;
	}