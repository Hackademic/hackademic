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
require_once(HACKADEMIC_PATH.'model/common/class.Article.php');
require_once(HACKADEMIC_PATH.'model/common/class.Challenge.php');

define("ARTIFACT_TYPE_CHALLENGE",1);
define("ARTIFACT_TYPE_ARTICLE",0);

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
    $sql = "INSERT INTO module_contents(module_id, artifact_id, artifact_type, artifact_order) VALUES (:module_id, :artifact_id, :artifact_type, :order)";
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
   * Gets all artifacts for the module with the specified id.
   *
   * @param $id
   * @return mixed $self
   */
  public static function get_by_module_id($id) {
  	global $db;
  	$params = array(':id' => $id);
  	$sql = "SELECT * FROM module_contents WHERE module_id = :id";
  	$result_array = self::findBySQL($sql, $params);
  	return !empty($result_array) ? $result_array : false;
  }
  /**
   * Gets the id for the artifact_id,module_id pair
   *
   * @param $artifact
   * @return mixed $self
   */
  public static function get_id($artifact) {
  	global $db;
  	$params = array(':artifact_id' => $artifact->artifact_id,
  	  				'module_id' => $artifact->module_id);
  	
  	$sql = "SELECT DISTINCT * FROM module_contents WHERE artifact_id = :artifact_id AND module_id = :module_id";
  	$result_array = self::findBySQL($sql, $params);
 //	echo '<p>get_id ';var_dump($result_array);echo'</p>';
  	return !empty($result_array) ? array_shift($result_array) : false;
  }
  /**
   * Gets all challenges for the module with the specified id.
   *
   * @param $id
   * @return mixed $self
   */
  public static function get_module_challenges($id) {
  	global $db;
  	$params = array(':id' => $id);
  	$sql = "SELECT * FROM module_contents WHERE module_id = :id AND artifact_type =".ARTIFACT_TYPE_CHALLENGE;
  	$result_array = self::findBySQL($sql, $params);
  	$ra = array();
  	foreach($result_array as $item){
  		array_push($ra, Challenge::getChallenge($item->artifact_id));
  	}
  	return !empty($ra) ? $ra : false;
  
  }
  /**
   * Gets all challenges which do not belong to the module with the specified id.
   *
   * @param $id
   * @return mixed $challenges
   */
  public static function get_challenges_not_in_the_module($id) {
  	global $db;
  	$params = array(':id' => $id);
  	$sql = "SELECT DISTINCT title,challenges.id FROM challenges,module_contents WHERE challenges.id
  			 NOT IN(SELECT artifact_id FROM module_contents WHERE module_id=:id AND artifact_type=".ARTIFACT_TYPE_CHALLENGE.")";
  	
  	$query = $db->read($sql, $params, self::$action_type);
	$result_array = array();
		while ($row = $db->fetchArray($query)) {
			array_push($result_array, $row);
		}
		//var_dump($result_array);
		return $result_array;
  }
  /**
   * Gets all articles for the module with the specified id.
   *
   * @param $id
   * @return mixed $articles
   */
  public static function get_module_articles($id) {
  	global $db;
  	$params = array(':id' => $id);
  	$sql = "SELECT * FROM module_contents WHERE module_id = :id AND artifact_type =".ARTIFACT_TYPE_ARTICLE;
  	$result_array = self::findBySQL($sql, $params);
  	$ra = array();
  	foreach($result_array as $item){
  		array_push($ra, Article::getArticle($item->artifact_id));
  	}
  	return !empty($ra) ? $ra : false;
  }
  /**
   * Gets all articles which do not belong to the module with the specified id.
   *
   * @param $id
   * @return mixed $self
   */
  public static function get_articles_not_in_the_module($id) {
  		global $db;
  	$params = array(':id' => $id);
  	$sql = "SELECT DISTINCT title,articles.id FROM articles,module_contents WHERE articles.id
  			 NOT IN(SELECT artifact_id FROM module_contents WHERE module_id=:id AND artifact_type=".ARTIFACT_TYPE_ARTICLE.")";
  	
  	$query = $db->read($sql, $params, self::$action_type);
	$result_array = array();
		while ($row = $db->fetchArray($query)) {
			array_push($result_array, $row);
		}
		//var_dump($result_array);
		return $result_array;
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
    $sql = "UPDATE module_contents  SET module_id=:module_id, artifact_id=:artifact_id, artifact_type=:artifact_type, artifact_order=:order  WHERE id = :id";
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
  	//echo '<p>artifact === ';var_dump($artifact);echo'</p>';
  	//echo '<p>artifac->id === ';var_dump($artifact->id);echo'</p>';
    global $db;
    $params = array(':id' => $artifact->id);
    $sql = $sql = "DELETE FROM module_contents WHERE id = :id";
    $query = $db->delete($sql, $params, self::$action_type);
    //var_dump($db->affectedRows($query));
  }

 
  public static function dropTable() {
  	global $db;
  	$sql = "Drop TABLE IF  EXISTS `module_contents`";
  	$db->query($sql);
  }
  
  /**
   * Creates the plugin's table if it does not already exist.
   */
  public static function createTable() {
    global $db;
    $sql = "CREATE TABLE IF NOT EXISTS module_contents (
		 id int(11) NOT NULL AUTO_INCREMENT,
		 module_id int(11),
		 artifact_id int(11),
		 artifact_type int(11),
		 artifact_order int(11),
    	 PRIMARY KEY (id)
    	)";
    $db->query($sql);
    $params = null;
    $sql = "INSERT INTO module_contents(module_id, artifact_id, artifact_type, artifact_order) VALUES (-1, -1, -1, -1)";
    $db->create($sql, $params, self::$action_type);
    
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
