<?php
/**
 *
 * Hackademic-CMS/admin/model/class.Classes.php
 *
 * Hackademic Classes Model
 * This class is for interacting with the Classes table in the DB
 *
 * Copyright (c) 2012 OWASP
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
 * @author Pragya Gupta <pragya18nsit[at]gmail[dot]com>
 * @author Konstantinos Papapanagiotou <conpap[at]gmail[dot]com>
 * @license http://www.gnu.org/licenses/gpl.html
 * @copyright 2012 OWASP
 *
 */
require_once(HACKADEMIC_PATH."model/common/class.HackademicDB.php");
require_once(HACKADEMIC_PATH."admin/model/class.ClassMemberships.php");
require_once(HACKADEMIC_PATH."admin/model/class.ClassChallenges.php");

class Classes {

	public $id;
	public $name;
	public $date_created;
	public $archive;

	public static function addClass($class_name, $date_created) {
		global $db;
		$params=array(':class_name' => $class_name,
				':date_created' => $date_created);
		$sql = "INSERT INTO classes(name,date_created)";
		$sql .= " VALUES (:class_name,:date_created)";
		$query = $db->query($sql,$params);
		if ($db->affectedRows($query)) {
			return true;
		} else {
			return false;
		}
	}

	public static function updateClassName($class_id , $class_name) {
		global $db;
		$params=array(':id' => $class_id,':class_name' => $class_name);
		$sql = "UPDATE classes SET name = :class_name";
		$sql .= " WHERE id = :id ";
		$query = $db->query($sql,$params);
		if ($db->affectedRows($query)) {
			return true;
		} else {
			return false;
		}
	}

	public static function getClassByName($class_name){
		global $db;
		$params=array(':class_name' => $class_name);
		$sql = "SELECT * FROM classes WHERE name = :class_name";
		$query = $db->query($sql,$params);
		$result_array=self::findBySQL($sql,$params);
		return !empty($result_array)?array_shift($result_array):false;
	}
	public static function getClass($class_id) {
		global $db;
		$params=array(':id' => $class_id);
		$sql = "SELECT * FROM classes WHERE id = :id";
		$query = $db->query($sql,$params);
		$result_array=self::findBySQL($sql,$params);
		return !empty($result_array)?array_shift($result_array):false;
	}

	public static function getNumberOfClasses($search=null,$category=null) {
		global $db;
		if ($search != null && $category != null) {
			$params[':search_string'] = '%'.$search.'%';
			switch($category){
				case "name":
					$sql = "SELECT COUNT(*) as num FROM classes WHERE name LIKE :search_string ";
					break;
			}
			$query = $db->query($sql,$params);
		} else {
			$sql = "SELECT COUNT(*) as num FROM classes WHERE archive =0";
			$query = $db->query($sql);
		}
		$result = $db->fetchArray($query);
		return $result['num'];
	}

	public static function getAllClasses() {
		global $db;
		$sql = "SELECT * FROM classes WHERE archive = 0 ";
		$query = $db->query($sql);
		$result_array=self::findBySQL($sql);
		return $result_array;
	}

	public static function getNClasses ($start, $limit,$search=null,$category=null) {
		global $db;
		$params = array(
				':start' => $start,
				':limit' => $limit
			       );
		if ($search != null && $category != null) {
			$params[':search_string'] = '%'.$search.'%';
			switch ($category) {
				case "name":
					$sql = "SELECT * FROM classes WHERE name LIKE :search_string  LIMIT :start, :limit";
					break;
			}
		} else {
			$sql= "SELECT * FROM classes ORDER BY id LIMIT :start, :limit ";
		}

		$result_array=self::findBySQL($sql,$params);
		return $result_array;
	}

	private static function findBySQL($sql,$params=NULL) {
		global $db;
		$result_set=$db->query($sql,$params);
		$object_array=array();
		while($row=$db->fetchArray($result_set)) {
			$object_array[]=self::instantiate($row);
		}
		return $object_array;
	}

	public static function instantiate($record) {
		$object=new self;
		foreach($record as $attribute=>$value) {
			if($object->hasAttribute($attribute)) {
				$object->$attribute=$value;
			}
		}
		return $object;
	}

	private function hasAttribute($attribute) {
		$object_vars=get_object_vars($this);
		return array_key_exists($attribute,$object_vars);
	}

	public static function deleteClass($id){
		global $db;
		$params=array(':id' => $id);
		$sql="DELETE FROM classes WHERE id = :id";
		$query = $db->query($sql,$params);
		ClassChallenges::deleteAllMembershipsOfClass($id);
		ClassMemberships::deleteAllMembershipsOfClass($id);
		if ($db->affectedRows($query)) {
			return true;
		} else {
			return false;
		}
	}

	public function doesClassExist($classname){
		global $db;
		$sql = "SELECT * FROM classes WHERE name = :classname";
		$params = array(
				':classname' => $classname
			       );
		$query = $db->query($sql, $params);
		$result = $db->numRows($query);
		if ($result) {
			return true;
		} else {
			return false;
		}
	}

	public static function archiveClass($id){
		global $db;
		$params=array(':id' => $id);
		$sql="UPDATE classes SET archive= 1 ";
		$sql .="WHERE id = :id";
		$query = $db->query($sql,$params);
		if ($db->affectedRows($query)) {
			return true;
		} else {
			return false;
		}
	}

	public static function unarchiveClass($id){
		global $db;
		$params=array(':id' => $id);
		$sql="UPDATE classes SET archive= 0 ";
		$sql .="WHERE id = :id";
		$query = $db->query($sql,$params);
		if ($db->affectedRows($query)) {
			return true;
		} else {
			return false;
		}
	}
}
