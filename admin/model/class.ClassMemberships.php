<?php
/**
 *
 * Hackademic-CMS/admin/mode/class.ClassMemberships.php
 *
 * Hackademic Class Memberships Model
 * This class is for interacting with the class_memberships table in DB
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

require_once(HACKADEMIC_PATH."admin/model/class.Classes.php");
require_once(HACKADEMIC_PATH."model/common/class.HackademicDB.php");

class ClassMemberships {
	public $id;
	public $user_id;
	public $class_id;
	public $name;//class name
	public $date_created;

	public static function addMembership($user_id,$class_id){
		global $db;
		$date = date('Y-m-d H:i:s');
		$params=array(':user_id' => $user_id,':class_id' => $class_id,':date_created' => $date);
		$sql="INSERT INTO class_memberships(user_id,class_id,date_created)";
		$sql .= " VALUES (:user_id ,:class_id ,:date_created)";
		$query = $db->query($sql,$params);
		if ($db->affectedRows($query)) {
			return true;
		} else {
			return false;
		}
	}

	public static function getMembershipsOfUserObjects($user_id) {
	    $classes = self::getMembershipsOfUser($user_id);
	    $object_array = array();
	    foreach ($classes as $class) {
		$temp = array(
		    'id' => $class['class_id'],
		    'name' => $class['name']
		);
		$obj = Classes::instantiate($temp);
		array_push($object_array, $obj);
	    }
	    return $object_array;
	}
	/*
	 * Returns an array with
	 *  all the classes the user is in
	 * */
	public static function getMembershipsOfUser($user_id) {
		global $db;
		$params=array(':user_id' => $user_id);
		$sql = "SELECT class_memberships.class_id, classes.name FROM class_memberships";
		$sql .= " LEFT JOIN classes ON class_memberships.class_id = classes.id WHERE";
		$sql .= " class_memberships.user_id = :user_id";
		$query = $db->query($sql,$params);
		$result_array = array();
		while ($row = $db->fetchArray($query)) {
			array_push($result_array, $row);
		}
		return $result_array;
	}

	public static function doesMembershipExist($user_id, $class_id) {
		global $db;
		$params=array(':user_id' => $user_id,':class_id' => $class_id);
		$sql= "SELECT * FROM class_memberships";
		$sql .= " WHERE user_id = :user_id AND class_id = :class_id";
		$query = $db->query($sql,$params);
		if ($db->numRows($query)) {
			return true;
		} else {
			return false;
		}
	}

	public static function deleteMembership($user_id,$class_id){
		global $db;
		$params=array(':user_id'=>$user_id,':class_id'=>$class_id);
		$sql="DELETE FROM class_memberships WHERE user_id=:user_id AND class_id=:class_id";
		$query = $db->query($sql,$params);
		if ($db->affectedRows($query)) {
			return true;
		} else {
			return false;
		}
	}

	public static function deleteAllMemberships($user_id){
		global $db;
		$sql = "DELETE FROM class_memberships WHERE user_id=:user_id";
		$params = array(
				':user_id' => $user_id
			       );
		$query = $db->query($sql, $params);
		if ($db->affectedRows($query)) {
			return true;
		} else {
			return false;
		}
	}

	public static function deleteAllMembershipsOfClass($class_id){
		global $db;
		$params = array(
				':class_id' => $class_id
			       );
		$sql="DELETE FROM class_memberships WHERE class_id=:class_id";
		$query = $db->query($sql,$params);
		if ($db->affectedRows($query)) {
			return true;
		} else {
			return false;
		}
	}

	public static function getAllMemberships($class_id) {
		global $db;
		$params=array(':class_id' => $class_id);
		$sql = "SELECT class_memberships.user_id, users.username FROM class_memberships ";
		$sql .= "LEFT JOIN users on class_memberships.user_id = users.id WHERE ";
		$sql .= "class_memberships.class_id = :class_id";
		$query = $db->query($sql,$params);
		$result_array = array();
		while ($row = $db->fetchArray($query)) {
			array_push($result_array, $row);
		}
		return $result_array;
	}
}
