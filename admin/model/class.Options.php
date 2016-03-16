<?php
/**
 *
 * Hackademic-CMS/admin/mode/class.Options.php
 *
 * Hackademic Options Model
 * This class handles the options in the database and holds options data
 *
 * Copyright (c) 2013 OWASP
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
 *
 * @author Daniel Kvist <daniel[at]danielkvist[dot]net>
 * @license http://www.gnu.org/licenses/gpl.html
 * @copyright 2013 OWASP
 *
 */
require_once(HACKADEMIC_PATH."model/common/class.HackademicDB.php");

class Options {

  public $name;
  public $value;

  private static $action_name = 'options';

  /**
   * Adds an option with the given name and value to the database
   *
   * @param $option_name the name of the option, must be unique
   * @param $option_value the value of the option
   * @return bool true if successful
   */
  public static function addOption($option_name, $option_value) {
    global $db;
    if($option_name != '') {
      $params = array(
        ':option_name' => $option_name,
        ':option_value' => json_encode($option_value)
      );
      $sql = "INSERT INTO options(option_name, option_value) ";
      $sql .= "VALUES (:option_name, :option_value)";

      $query = $db->create($sql, $params, self::$action_name);

      if ($db->affectedRows($query)) {
          return TRUE;
      }
    }
    return FALSE;
  }


  /**
   * Gets an option from the database and returns an instance of the option
   * with its name and value.
   *
   * @param $option_name the name of the option
   * @return Options an option instance
   */
  public static function getOption($option_name) {
    global $db;

    $params = array(':option_name' => $option_name);
    $sql = "SELECT * FROM options WHERE option_name = :option_name";

    $result_set = $db->read($sql, $params, self::$action_name);
    $row = $db->fetchArray($result_set);

    $option = new self;
    $option->name = $row['option_name'];
    $option->value = json_decode($row['option_value']);

    return $option;
  }

  /**
   * Updates the value of an option.
   *
   * @param $option_name the name of the option to update
   * @param $option_value the value to update to
   * @return bool true if successful
   */
  public static function updateOption($option_name, $option_value) {
    global $db;
    $params = array(
      ':option_name' => $option_name,
      ':option_value' => json_encode($option_value)
    );

    $sql = "UPDATE options SET option_value = :option_value ";
    $sql .= "WHERE option_name = :option_name";

    $query = $db->update($sql, $params, self::$action_name);
    if ($db->affectedRows($query)) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  /**
   * Deletes an option from the database with the given name.
   *
   * @param $option_name the option to delete
   * @return bool true if successful
   */
  public static function deleteOption($option_name) {
    global $db;
    $params = array(':option_name' => $option_name);

    $sql = "DELETE FROM options WHERE option_name = :option_name";

    $query = $db->delete($sql, $params, self::$action_name);
    if ($db->affectedRows($query)) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

}
