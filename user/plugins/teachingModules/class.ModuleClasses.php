<?php
/**
 *
 * Class Module Classes
 *
 * This class handles the database interactions for adding modules to a class
 *
 * @author: Spyros Gasteratos
 * @license: GPL2
 *
 */

require_once(HACKADEMIC_PATH . "model/common/class.HackademicDB.php");

class ModuleClasses {

  private static $action_type = 'teaching_module_classes';

  private static $table_name = 'module_classes';

  public $id;
  public $module_id;
  public $class_id;

 
 /**
   * Adds a new class for the given module
   *
   * @param $classid the class to be associated to the module
   * @param $moduleid the module
   */
  public static function add($classid, $moduleid) {
    global $db;
    $params = array(
      ':classid' => $classid,
      ':moduleid' => $moduleid,
    );
    $sql = "INSERT INTO module_classes(module_id, class_id) VALUES (:module_id, :classid)";
    $db->create($sql, $params, self::$action_type);
  }

  /**
   * Gets all classes that the module is assigned to.
   *
   * @param $moduleid
   * @return object $self
   */
  public static function getClasses($moduleid) {
    global $db;
    $params = array(':id' => $moduleid);
    $sql = "SELECT * FROM module_classes WHERE module_id = id";
    $result_array = self::findBySQL($sql, $params);
    return !empty($result_array) ? array_shift($result_array) : false;	
  }
  /**
   * Gets all modules for the classs with the specified id.
   *
   * @param $id
   * @return mixed $self
   */
  public static function getModules($id) {
  	global $db;
  	$params = array(':id' => $id);
  	$sql = "SELECT * FROM module_classes WHERE class_id = :id";
  	$result_array = self::findBySQL($sql, $params);
  	return !empty($result_array) ? $result_array : false;
  }
  /**
   * Deletes the row with the coresponding  id.
   *
   * @param $moduleClass a moduleClass objecct with the correct id
   */
  public static function delete($moduleClass) {
    global $db;
    $params = array(':id' => $module->id);
    $sql = $sql = "DELETE FROM module_classes WHERE id = :id";
    $db->delete($sql, $params, self::$action_type);
  }

 
  public static function dropTable() {
  	global $db;
  	$sql = "Drop TABLE IF  EXISTS `module_classes`";
  	$db->query($sql);
  }
  
  /**
   * Creates the plugin's table if it does not already exist.
   */
  public static function createTable() {
    global $db;
    $sql = "CREATE TABLE IF NOT EXISTS `module_classes` (
		 `id` int(11) NOT NULL AUTO_INCREMENT,
		 `module_id` int(11) NOT NULL,
		 `class_id` int(11) NOT NULL)";
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
