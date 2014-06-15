<?php
/**
 *
 * Class Module Contents
 *
 * This class handles the database interactions for adding contents to a module.
 *
 * @author: Spyros Gasteratos
 * @license: GPL2
 *
 */

require_once(HACKADEMIC_PATH . "model/common/class.HackademicDB.php");

class ModuleContents {

  private static $action_type = 'teaching_module_contents';

  private static $table_name = 'module_contents';

  public $id;
  public $module_id;
  public $artifact_id;
  public $artifact_type;
  public $artifact_order;

 
 /**
   * Adds a new artifact for the given module
   *
   * @param $artifact the artifact(module content) to be added
   */
  public static function add($artifact) {
    global $db;
    $params = array(
      ':module_id' => $artifact->module_id,
      ':artifact_id' => $artifact->artifact_id,
      ':artifact_type' => $artifact->artifact_type,
      ':order' => $artifact->artifact_order,
    );
    $sql = "INSERT INTO module_contents(module_id, art_id, art_type, art_order) VALUES (:module_id, :artifact_id, :artifact_type, :order)";
    $db->create($sql, $params, self::$action_type);
  }

  /**
   * Gets artifact with the specified id from the database.
   *
   * @param $id
   * @return object $self
   */
  public static function get($id) {
    global $db;
    $params = array(':id' => $id);
    $sql = "SELECT * FROM module_contents WHERE id = id";
    $result_array = self::findBySQL($sql, $params);
    return !empty($result_array) ? array_shift($result_array) : false;	
  }

  /**
   * Updates the artifact info
   *
   * @param $module moduleContents object with the updated values
   */
  public static function update($artifact) {
    global $db;
    $params = array(
      ':module_id' => $artifact->module_id,
      ':artifact_id' => $artifact->artifact_id,
      ':artifact_type' => $artifact->artifact_type,
      ':order' => $artifact->order,
    );
    $sql = "UPDATE module_contents  SET module_id=:module_id, artifact_id=:artifact_id, art_type=:artifact_type, art_order=:order  WHERE id = :id";
    $db->update($sql, $params, self::$action_type);
    if ($db->affectedRows($query)) {
    	return true;
    } else {
    	return false;
    }
  }

  /**
   * Deletes the row with the coresponding  id.
   *
   * @param $artifact an artifact objecct with the correct id
   */
  public static function delete($artifact) {
    global $db;
    $params = array(':id' => $module->id);
    $sql = $sql = "DELETE FROM module_contents WHERE id = :id";
    $db->delete($sql, $params, self::$action_type);
  }


  /**
   * Creates the plugin's table if it does not already exist.
   */
  public static function createTable() {
    global $db;
    $sql = "CREATE TABLE IF NOT EXISTS `module_contents` (
		 `id` int(11) NOT NULL AUTO_INCREMENT,
		 `module_id` int(11) NOT NULL,
		 `artifact_id` int(11) NOT NULL,
		 `art_type` int(11) NOT NULL,
		 `art_order` int(11) NOT NULL)";
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
