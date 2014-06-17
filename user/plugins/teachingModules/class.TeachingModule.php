<?php
/**
 *
 * Class Teaching Module
 *
 * This class handles the database interactions for connecting
 * articles with challenges.
 *
 * @author: Spyros Gasteratos
 * @license: GPL2
 *
 */

require_once(HACKADEMIC_PATH . "model/common/class.HackademicDB.php");

class TeachingModule {

  private static $action_type = 'teaching_module';

  private static $table_name = 'teaching_modules';

  public $id;
  public $name;
  public $date_added;
  public $added_by;

 
 /**
   * Adds a new module to the database
   *
   * @param $name the module name
   * @param $added_by the username who added it
   */
  public static function add($name, $added_on, $added_by) {
    global $db;
    $params = array(
      ':name' => $name,
      ':added_on' => $added_on,
      ':added_by' => $added_by
    );
    $sql = "INSERT INTO teaching_modules(name, added_on, added_by) VALUES (:name, :added_on, :added_by)";
    $db->create($sql, $params, self::$action_type);
  }

  /**
   * Gets module with the specified id from the database.
   *
   * @param $id
   * @return object $self
   */
  public static function get($id) {
    global $db;
    $params = array(':id' => $id);
    $sql = "SELECT * FROM teaching_modules WHERE id = :id";
    $result_array = self::findBySQL($sql, $params);
    return !empty($result_array) ? array_shift($result_array) : false;	
  }

  /**
   * Gets module with the specified name from the database.
   *
   * @param $id
   * @return object $self
   */
  public static function get_by_name($name) {
  	global $db;
  	$params = array(':name' => $name);
  	$sql = "SELECT * FROM teaching_modules WHERE name = :name";
  	$result_array = self::findBySQL($sql, $params);
  	return !empty($result_array) ? array_shift($result_array) : false;
  }
  /**
   * Updates the module info.
   *
   * @param $module module object with the updated values
   */
  public static function update($module) {
    global $db;
    $params = array(
      ':id' => $module->id,
      ':name' => $module->name,
      ':added_by' => $module->added_by
    );
    $sql = "UPDATE teaching_modules  SET name = :name, added_bt = :added_by  WHERE id = :id";
    $db->update($sql, $params, self::$action_type);
    if ($db->affectedRows($query)) {
    	return true;
    } else {
    	return false;
    }
  }

  /**
   * Deletes the row with the coresponding module id.
   *
   * @param $module a module objecct with the correct id
   */
  public static function delete($module) {
    global $db;
    $params = array(':id' => $module->id);
    $sql = $sql = "DELETE FROM teaching_modules WHERE id = :id";
    $db->delete($sql, $params, self::$action_type);
  }
  
  public static function dropTable() {
  	global $db;
  	$sql = "Drop TABLE IF  EXISTS `teaching_modules`";
  	$db->query($sql);
  }

  /**
   * Creates the plugin's table if it does not already exist.
   */
  public static function createTable() {
    global $db;
    $sql = "CREATE TABLE IF NOT EXISTS `teaching_modules` (
		`id` int(11) NOT NULL,
 		 `name` varchar(128) NOT NULL,
		  `added_on` date NOT NULL,
		  `added_by` int(11) NOT NULL
 	     PRIMARY KEY (`id`))";
    $db->query($sql);
  }
  
  private static function findBySQL($sql, $params = NULL) {
		global $db;
		$result_set = $db->read($sql, $params, self::$action_type);
		$object_array = array();
		while($row = $db->fetchArray($result_set)) {
			$object_array[] = self::instantiate($row);
		}
		return $object_array;
	}
  public static function instantiate($record) {
		$object = new self;
		foreach($record as $attribute => $value) {
			if($object->hasAttribute($attribute)) {
				$object->$attribute = $value;
			}
		}
		return $object;
  }

}
