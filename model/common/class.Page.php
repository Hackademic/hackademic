<?php
/**
 * Hackademic-CMS/model/common/class.Page.php
 *
 * Hackademic Page class
 * Class for Hackademic's pages
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

class Page
{
  
  protected static $action_type = 'page';
  
  /**
   * Retrives the file for the given url
   * 
   * @param URL $url url to load the file for
   *
   * @return the path to the file
   */
  public static function getFile($url)
  {
    global $db;
    $params = array(':url' => $url);
    $sql = "SELECT file FROM pages WHERE url = :url";
    $result_set = $db->read($sql, $params, self::$action_type);
    return $db->fetchArray($result_set);
  }

}
