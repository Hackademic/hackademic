<?php
/**
 * Hackademic-CMS/admin/mode/class.PageBackend.php
 *
 * Hackademic Page Backend Model
 * This class extends the functionality of Page class adding functions specifically
 * required for backend to be able to add, update and delete pages.
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
require_once HACKADEMIC_PATH . "model/common/class.Page.php";
class PageBackend extends Page
{

  /**
   * Adds a page mapping from the given url to the file.
   *
   * @param string $url  The url to map
   * @param File   $file The path to the file that generates the page view.
   *                     The path should be relative to the HACKADEMIC_PATH variable
   *                     which is the web root as default.
   *
   * @return true if added
   */
	public static function addPage($url, $file)
	{
		global $db;
    
		$params = array(
		  ':url' => $url,
		  ':file' => $file
    );

		$sql = "INSERT INTO pages(url, file) VALUES (:url, :file)";
		$query = $db->create($sql, $params, self::$action_type);
		if ($db->affectedRows($query)) {
			return true;
		} else {
			return false;
		}
	}


  /**
   * Updates a page mapping from the given url to the new file.
   *
   * @param String $url  The url to update the mapping for
   * @param file   $file The new path to the file that generates the page view.
   *                     The path should be relative to the HACKADEMIC_PATH variable
   *                     which is the web root as default.
   *
   * @return true if updated
   */
	public static function updatePage($url, $file)
	{
		global $db;
    
		$params = array(
		  ':url' => $url,
		  ':file' => $file
    );

		$sql = "UPDATE pages SET file = :file WHERE url = :url";
		$query = $db->update($sql, $params, self::$action_type);
		if ($db->affectedRows($query)) {
			return true;
		} else {
			return false;
		}
	}

  /**
   * Deletes a page mapping for the given url.
   *
   * @param String $url the url to delete the page mapping for.
   *
   * @return true if deleted
   */
	public static function deletePage($url)
	{
		global $db;
    
		$params = array(':url' => $url);
		$sql = "DELETE FROM pages WHERE url = :url";
		$query = $db->delete($sql, $params, self::$action_type);
		if ($db->affectedRows($query)) {
			return true;
		} else {
			return false;
		}
	}

}
