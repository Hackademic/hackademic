<?php

/**
 * Hackademic-CMS/test/admin/model/class.OptionsTest.php
 *
 * Hackademic Options Class Test
 * Class for Testing Hackademic's Options model
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

class OptionsTest extends PHPUnit_Framework_TestCase {

    public static $option_name = 'test_add_option';
    public static $option_value = 'test_add_option_value';

    /**
     * Sets up a db connection and initiates the required constants that are needed
     * for the tests and includes.
     */
    public function setUp() {
        global $db;
        $db = new HackademicDB();
        Loader::init();
        require_once('admin/model/class.Options.php');
    }

    /**
     * Removes the test option name row from the database after each test.
     */
    public function tearDown() {
        global $db;

        $db->query("delete from options where option_name = '" . self::$option_name . "'");
    }

    /**
     * Tests that the addOption function actually inserts a value into the database.
     */
    public function test_add_option_return_true() {
        global $db;

        $result = Options::addOption(self::$option_name, self::$option_value);
        $result_set = $db->query("select * from options where option_name = '" . self::$option_name . "'");
        $row = $db->fetchArray($result_set);

        assert($result === true);
        assert(json_decode($row['option_value']) == self::$option_value);
    }

    /**
     * Tests that an empty option name will not be inserted since the option name
     * is they key.
     */
    public function test_add_option_empty_option_name_return_false() {
        $result = Options::addOption('', self::$option_value);
        assert($result === false);
    }

    /**
     * Tests the updateOption to make sure the option name is updated.
     */
    public function test_update_existing_option_return_true() {
        global $db;

        $update_value = self::$option_value . '_updated';
        Options::addOption(self::$option_name, self::$option_value);

        $result = Options::updateOption(self::$option_name, $update_value);
        $result_set = $db->query("select * from options where option_name = '" . self::$option_name . "'");
        $row = $db->fetchArray($result_set);

        assert($result === true);
        assert(json_decode($row['option_value']) == $update_value);
    }

    /**
     * Tests the return statement of trying to update a non-existing option.
     */
    public function test_update_non_existing_option_return_false() {
        $result = Options::updateOption(self::$option_name, self::$option_name);
        assert($result === false);
    }

    /**
     * Tests the get existing option with a single string value
     */
    public function test_get_existing_option_string_value() {
        Options::addOption(self::$option_name, self::$option_value);
        $result = Options::getOption(self::$option_name);
        assert($result->value == self::$option_value);
    }

    /**
     * Tests the get existing option with a string array value
     */
    public function test_get_existing_option_string_array_value() {
        $option_value_array = array('test1', 'test2');
        Options::addOption(self::$option_name, $option_value_array);
        $result = Options::getOption(self::$option_name);
        assert($result->value == $option_value_array);
    }

}