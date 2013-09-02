<?php

/**
 * Hackademic-CMS/test/model/common/class.PageTest.php
 *
 * Hackademic Page Class Test
 * Class for Testing Hackademic's Page mapping
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


class PageTest extends PHPUnit_Framework_TestCase {

    public function setUp() {
        global $db;
        $db = new HackademicDB();
        Loader::init();
        require_once('model/common/class.Page.php');
    }
    public function tearDown(){ }

    /**
     * Tests to make sure the get file method actually returns a row with the
     * file. To do that we first create a new row, fetch it and delete it.
     */
    public function test_get_file() {
      global $db;
      
      $url = 'testurl';
      $file = 'testfile';
      $params = array(
        ':url' => $url,
        ':file' => $file
      );
      
      $sql = "INSERT INTO pages (url, file) VALUES (:url, :file)";
      $db->query($sql, $params);
      $row = Page::getFile($url);
      
      assert($file == $row['file']);
      
      $params = array(':url' => $url);
      $sql = "DELETE FROM pages WHERE url = :url";
      $db->query($sql, $params);
    }
}
