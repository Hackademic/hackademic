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
	':moduleid' => $moduleid,
    ':classid' => $classid
    );
    var_dump($moduleid);
    var_dump($classid);
    $sql = "INSERT INTO module_classes(module_id, class_id) VALUES (:moduleid, :classid)";
    $query = $db->create($sql, $params, self::$action_type);
	var_dump($db->affectedRows($query));
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
    $sql = "SELECT * FROM module_classes WHERE module_id = :id";
    $result_array = self::findBySQL($sql, $params);
	$ra = array();
  	foreach($result_array as $item){
  		array_push($ra, Classes::getClass($item->class_id));
  	}
  	return !empty($ra) ? $ra : false;
  }
  /**
   * Checks if the module is assigned to class.
   *
   * @param $self
   * @return boolean
   */
  public static function isMemberOf($moduleClass) {
  	global $db;
  	$params = array(':id' => $moduleClass->module_id,
  					':cid'=> $moduleClass->class_id);
  	$sql = "SELECT * FROM module_classes WHERE module_id = :id
  			 AND class_id = :cid";
  	$result_array = self::findBySQL($sql, $params);
  	return !empty($result_array) ? TRUE : false;
  }
  /**
   * Gets the module-class association for the given module and class.
   *
   * @param $self
   * @return mixed $self
   */
  public static function get_by_mod_class($mod_class) {
  	global $db;
  	$params = array(':mod_id' => $mod_class->module_id,
  					':class_id' => $mod_class->class_id);
  	$sql = "SELECT * FROM module_classes WHERE 
  			class_id=:class_id AND module_id=:mod_id";
  	$result_array = self::findBySQL($sql, $params);
  	return !empty($result_array) ? array_shift($result_array) : false;
  }
  
  /**
   * Gets all modules for the classs with the specified id.
   *
   * @param $id
   * @return mixed $self
   */
  public static function getModules($class_id) {
  	global $db;
  	$params = array(':id' => $class_id);
  	$sql = "SELECT * FROM module_classes WHERE class_id = :id";
  	$result_array = self::findBySQL($sql, $params);
	$ra = array();
  	foreach($result_array as $item){
  		array_push($ra, TeachingModule::get($item->module_id));
  	}
  	return !empty($ra) ? $ra : false;
  	 }
  /**
   * Deletes the row with the coresponding  id.
   *
   * @param $moduleClass a moduleClass objecct with the correct id
   */
  public static function delete($moduleClass) {
    global $db;
    $params = array(':id' => $moduleClass->id);
    $sql = $sql = "DELETE FROM module_classes WHERE id = :id";
    $db->delete($sql, $params, self::$action_type);
  }
  /**
   * Deletes the modules for the class_id.
   *
   * @param $class_id the class_id for which we delete the modules
   */
  public static function deleteAllModulesForClass($class_id) {
  	global $db;
  	$params = array(':id' => $class_id);
  	$sql = $sql = "DELETE FROM module_classes WHERE class_id = :id";
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
		 `module_id` int(11),
		 `class_id` int(11),
    	PRIMARY KEY (id)
  	)";
    $db->query($sql);
    $params = null;
    $sql = "INSERT INTO module_classes(module_id, class_id) VALUES (-1,-1)";
    $db->create($sql, $params, self::$action_type);
  }
  /*
   * Gets the modules that are not associated with the class_id given
   * @params $class_id
   * @returns mixed modules
   * */
  public static function get_not_memberships($class_id){
   		global $db;
  		$params = array(':id' => $class_id);
  		$sql = "SELECT DISTINCT teaching_modules.name,teaching_modules.id
  				 FROM teaching_modules,module_classes
  				 WHERE teaching_modules.id
  			 NOT IN(SELECT module_id FROM module_classes WHERE class_id=:id)";
  	
  	$query = $db->read($sql, $params, self::$action_type);
	$result_array = array();
		while ($row = $db->fetchArray($query)) {
			array_push($result_array, $row);
		}
		//var_dump($result_array);
		return $result_array;
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
  private function hasAttribute($attribute) {
  	$object_vars = get_object_vars($this);
  	return array_key_exists($attribute,$object_vars);
  }

}
