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
require_once(HACKADEMIC_PATH."model/common/class.HackademicDB.php");

class UserChallenges {
	public $id;//challenge_id
	public $title;//challenge_title
	public $pkg_name;
	public $availability;

	/*@returns: array
 * Get all challenges the use can solve*/
	public static function getChallengesOfUser($user_id) {
			global $db;
			$params=array(':user_id' => $user_id);
			$sql = "SELECT DISTINCT challenges.id, challenges.title,challenges.pkg_name, challenges.availability
					FROM challenges
					LEFT JOIN class_challenges ON challenges.id = class_challenges.challenge_id
					WHERE challenges.publish =1 AND (
					(visibility = 'public' AND availability = 'public') OR (
					class_id IN(
					SELECT class_memberships.class_id AS class_id
					FROM class_memberships WHERE
					class_memberships.user_id = :user_id
					)
						)
					)
					ORDER BY challenges.id
					";
			$result_array = self::findBySQL($sql,$params);
			//Debug::show($result_array,'all',$this,_FUNCTION_);
			return !empty($result_array)?$result_array:false;
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
}
