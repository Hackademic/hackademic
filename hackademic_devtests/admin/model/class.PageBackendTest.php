<?php

/**
 * Hackademic-CMS/test/admin/model/class.PageBackendTest.php
 *
 * Hackademic Page Backend Class Test
 * Class for Testing Hackademic's Page Backend model
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

class PageBackendTest extends PHPUnit_Framework_TestCase {

    public static $url = 'testurl';
    public static $file = 'testfile';

    /**
     * Sets up a db connection and initiates the required constants that are needed
     * for the tests and includes.
     */
    public function setUp() {
        global $db;
        $db = new HackademicDB();
        Loader::init();
        require_once('admin/model/class.PageBackend.php');
    }

    /**
     * Removes the test page name row from the database after each test.
     */
    public function tearDown() {
        global $db;

        $db->query("delete from pages where url = '" . self::$url . "'");
    }

    /**
     * Tests that the addPage function actually inserts a value into the database.
     */
    public function test_add_page_return_true() {
        global $db;

        $result = PageBackend::addPage(self::$url, self::$file);
        $result_set = $db->query("select * from pages where url = '" . self::$url . "'");
        $row = $db->fetchArray($result_set);

        assert($result === true);
        assert($row['file'] == self::$file);
    }

    /**
     * Tests the updateOption to make sure the page name is updated.
     */
    public function test_update_existing_page_return_true() {
        global $db;

        $update_value = self::$file . '_updated';
        PageBackend::addPage(self::$url, self::$file);

        $result = PageBackend::updatePage(self::$url, $update_value);
        $result_set = $db->query("select * from pages where url = '" . self::$url . "'");
        $row = $db->fetchArray($result_set);

        assert($result === true);
        assert($row['file'] == $update_value);
    }

    /**
     * Tests the return statement of trying to update a non-existing page.
     */
    public function test_update_non_existing_page_return_false() {
        $result = Options::updateOption(self::$url, self::$url);
        assert($result === false);
    }

}