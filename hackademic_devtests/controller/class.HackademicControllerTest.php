<?php

/**
 * Hackademic-CMS/test/admin/model/class.HackademicControllerTest.php
 *
 * Hackademic Hackademic Controller Test
 * Class for Testing Hackademic's HackademicController
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

global $hci;

class HackademicControllerTest extends PHPUnit_Framework_TestCase {

  /**
   * Sets up a db connection and initiates the required constants that are needed
   * for the tests and includes.
   */
  public function setUp() {
    global $db;
    $db = new HackademicDB();
    Loader::init();
  }

  /**
   * Tests the show action in the HackademicController. Note that this test generates
   * output and will break the test suite if it is not run with the
   * '--stderr' flag to direct output to stderr instead of stdout.
   */
  public function test_show_action() {
    global $hci;

    require_once("test/controller/implementations/class.HackademicControllerImplementation.php");
    $hci = new HackademicControllerImplementation();

    Plugin::add_action('show_test_show_action', 'show_test_show_action');
    $hci->setViewTemplate('user_login.tpl');
    $hci->generateView('test_show_action');
    assert($hci->called === TRUE);
  }

  /**
   * Closes the db and cleans up the hc global
   */
  public function tearDown() {
    global $db;
    $db->closeConnection();
  }

}

/**
 * Function that is called by the plugin api which sets a static variable
 * that can let the test that is running know that it was successful.
 *
 * @param $smarty
 */
function show_test_show_action($smarty) {
  global $hci;
  $hci->called = TRUE;
}
