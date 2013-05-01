<?php
/**
 *
 * Hackademic-CMS/model/common/class.User.php
 *
 * Hackademic User Model
 * Class for Hackademic's User Object
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
require_once(HACKADEMIC_PATH."model/common/class.Utils.php");
require_once(HACKADEMIC_PATH."model/common/class.ChallengeAttempts.php");
require_once(HACKADEMIC_PATH."model/common/class.UserHasChallengeToken.php");

class User {
	public $id;
	public $username;
	public $password;
	public $full_name;
	public $type;
	public $email;
	public $joined;
	public $last_visit;
	public $is_activated;
	public $token;

	public static function findByUserName($username) {
		global $db;
		$sql = "SELECT * FROM users WHERE username=:username LIMIT 1";
		$params = array(
				':username' => $username
			       );
		$result_array=self::findBySQL($sql, $params);
		return !empty($result_array)?array_shift($result_array):false;
	}

	public static function getUser($id) {
		global $db;
		$sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
		$params = array(
				':id' => $id
			       );
		$result_array=self::findBySQL($sql, $params);
		return !empty($result_array)?array_shift($result_array):false;
	}

	private static function findBySQL($sql, $params = NULL) {
		global $db;
		$result_set=$db->query($sql, $params);
		$object_array=array();
		while($row=$db->fetchArray($result_set)) {
			$object_array[]=self::instantiate($row);
		}
		return $object_array;
	}

	public static function addUser($username=null, $full_name=null, $email=null, $password=null,
			$joined=null, $is_activated=null, $type=null, $token=0) {
		global $db;
		$password = Utils::hash($password);

		$params = array(
				':username' => $username,
				':full_name' => $full_name,
				':email' => $email,
				':password' => $password,
				':joined' => $joined,
				':token' => $token
			       );
		if($is_activated!=null && $type!=null){
			$params[':is_activated'] = $is_activated;
			$params[':type'] = $type;
			$sql = "INSERT INTO users (username, full_name, email, password, joined, is_activated, type, token)";
			$sql .= " VALUES (:username, :full_name, :email, :password, :joined, :is_activated, :type, :token)";
		} else {
			$sql = "INSERT INTO users (username, full_name, email, password, joined, token)";
			$sql .= "VALUES (:username, :full_name, :email, :password, :joined, :token)";
		}
		$query = $db->query($sql, $params);
		if ($db->affectedRows($query)) {
			return true;
		} else {
			return false;
		}
	}

	public static function addToken($username, $token){
		global $db;
		$sql = "UPDATE users SET token=:token WHERE username = :username";
		$params = array(
				':token' => $token,
				':username' => $username
			       );
		$query = $db->query($sql, $params);
		if ($db->affectedRows($query)) {
			return true;
		} else {
			return false;
		}
	}

	public static function updatePassword($password, $username){
		global $db;
		$password = Utils::hash($password);
		$sql="UPDATE users SET password=:password, token = 0 WHERE username = :username";
		$params = array(
				':password' => $password,
				':username' => $username
			       );
		$query = $db->query($sql, $params);
		if ($db->affectedRows($query)) {
			return true;
		} else {
			return false;
		}
	}


	public static function updateLastVisit($username){
		global $db;
		$last_visit = date("Y-m-d H-i-s");
		$sql = "UPDATE users SET last_visit = :last_visit WHERE username = :username";
		$params = array(
				':last_visit' => $last_visit,
				':username' => $username
			       );
		$query = $db->query($sql, $params);
		if ($db->affectedRows($query)) {
			return true;
		} else {
			return false;
		}
	}


	public static function getNumberOfUsers($search=null,$category=null) {
		global $db;
		if ($search != null && $category != null) {
			$params[':search_string'] = '%'.$search.'%';
			switch ($category) {
				case "username":
					$sql = "SELECT COUNT(*) as num FROM users WHERE username LIKE :search_string";
					break;
				case "full_name":
					$sql = "SELECT COUNT(*) as num FROM users WHERE full_name LIKE :search_string";
					break;
				case "email":
					$sql = "SELECT COUNT(*) as num FROM users WHERE email LIKE :search_string";
					break;

			}
			$query = $db->query($sql,$params);
		} else {
			$sql = "SELECT COUNT(*) as num FROM users";
			$query = $db->query($sql);
		}

		$result = $db->fetchArray($query);
		return $result['num'];
	}

	public static function getNUsers ($start, $limit, $search=null, $category=null) {
		global $db;
		$params = array(
				':start' => $start,
				':limit' => $limit
			       );
		if ($search != null && $category != null) {
			$params[':search_string'] = '%'.$search.'%';
			switch ($category) {
				case "username":
					$sql = "SELECT * FROM users WHERE username LIKE :search_string LIMIT :start, :limit";
					break;
				case "full_name":
					$sql = "SELECT * FROM users WHERE full_name LIKE :search_string LIMIT :start, :limit";
					break;
				case "email":
					$sql = "SELECT * FROM users WHERE email LIKE :search_string LIMIT :start, :limit";
					break;
			}
		} else {
			$sql = "SELECT * FROM users ORDER BY id LIMIT :start, :limit";
		}
		$result_array=self::findBySQL($sql, $params);
		return $result_array;
	}
	public static function isUserActivated($username){
		global $db;
		$sql = "SELECT * FROM users WHERE username = :username AND is_activated = 1";
		$params = array(
				':username' => $username
			       );
		$query = $db->query($sql, $params);
		$result = $db->numRows($query);
		if ($result) {
			return true;
		} else {
			return false;
		}
	}
	public function doesUserExist($username){
		global $db;
		$sql = "SELECT * FROM users WHERE username = :username";
		$params = array(
				':username' => $username
			       );
		$query = $db->query($sql, $params);
		$result = $db->numRows($query);
		if ($result) {
			return true;
		} else {
			return false;
		}
	}

	public static function updateUser($id, $username, $full_name, $email, $password,
			$is_activated, $type) {
		global $db;
		$params = array(
				':username' => $username,
				':full_name' => $full_name,
				':email' => $email,
				':is_activated' => $is_activated,
				':type' => $type,
				':id' => $id
			       );
		if($password == '') {
			$sql = "UPDATE users SET username = :username, full_name = :full_name, email = :email, ";
			$sql .= " is_activated = :is_activated , type = :type WHERE id = :id";
		} else {
			$password = Utils::hash($password);
			$params[':password'] = $password;
			$sql = "UPDATE users SET username = :username, full_name = :full_name, email = :email, ";
			$sql .= " password=:password, is_activated = :is_activated , type = :type WHERE id = :id";
		}
		$query = $db->query($sql, $params);
		if ($db->affectedRows($query)) {
			return true;
		} else {
			return false;
		}
	}

	public static function deleteUser($id){
		global $db;
		$sql = "DELETE FROM users WHERE id=:id";
		$params = array(
				':id' => $id
			       );
		ClassMemberships::deleteAllMemberships($id);
		ChallengeAttempts::deleteChallengeAttemptByUser($id);
		$user = self::getUser($id);
		UserHasChallengeToken::deleteByUser($user->username);
		$query = $db->query($sql, $params);
		if ($db->affectedRows($query)) {
			return true;
		} else {
			return false;
		}
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

	public static function validateToken($username, $token){
		global $db;
		$sql = "SELECT * FROM users WHERE username=:username AND token=:token";
		$params = array(
				':username' => $username,
				':token' => $token
			       );
		$query = $db->query($sql, $params);
		$result = $db->numRows($query);
		if ($result) {
			return true;
		} else {
			return false;
		}
	}
}
