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
require_once(HACKADEMIC_PATH."model/common/class.Utils.php");

class UserHasChallengeToken {
	public $id;
	public $user_id;//username
	public $token;
	public $challenge_id;

  private static $action_type = 'user_has_challenge_token';

	public static function add($userid = null, $chid = null, $class_id = null, $token = null) {
		global $db;
		$params = array(
      ':user_id' => $userid,
      ':class_id' => $class_id,
      ':challenge_id' => $chid,
      ':token' => $token
    );
		$exists = self::find($userid, $chid, $class_id);
		if($exists != NULL){
			$sql =  'UPDATE  user_has_challenge_token SET token = :token
					 WHERE user_id = :user_id AND challenge_id = :challenge_id AND class_id = :class_id';
      $query = $db->update($sql, $params, self::$action_type);
		} else {
			$sql = 'INSERT INTO user_has_challenge_token(user_id,class_id,challenge_id,token) VALUES(
					:user_id,:class_id,:challenge_id,:token)';
      $query = $db->create($sql, $params, self::$action_type);
		}

		if ($db->affectedRows($query)) {
			return true;
		} else {
			return false;
		}
	}

	public static function deleteByUser($user_id){
		global $db;
		$params = array(':user_id' => $user_id);
		$sql = 'DELETE FROM user_has_challenge_token WHERE user_id = :user_id;';
	}

	public static function find($userid,$chid,$class_id){
		global $db;
		$sql = "SELECT * FROM user_has_challenge_token WHERE
				user_id= :user_id AND challenge_id= :challenge_id AND class_id = :class_id
				LIMIT 1";
		$params = array(
      ':user_id' => $userid,
      ':class_id' => $class_id,
      ':challenge_id' => $chid
    );
		$object_array = self::findBySQL($sql, $params);
		/*var_dump($userid);
		var_dump($chid);
		var_dump($object_array);die();*/
		return !empty($object_array) ? array_shift($object_array) : false;
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
		return array_key_exists($attribute, $object_vars);
	}
}
