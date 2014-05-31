<?php
/**
 *
 * Hackademic-CMS/model/common/class.ChallengeScoring.php
 *
 * Hackademic UserScore Class
 * Class for Hackademic's ScoringRule Object
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
 * @author Spyros Gasteratos
 * @author Konstantinos Papapanagiotou <conpap[at]gmail[dot]com>
 * @license http://www.gnu.org/licenses/gpl.html
 * @copyright 2013 OWASP
 *
 */

class UserScore{

	public $id;
	public $challenge_id;
	public $class_id;
	public $user_id;
	public $points;
	public $penalties_bonuses;

	/**
	 * Adds a score entry for a user solving the specific challenge
	 * this function is called each time the user tries the challenge
	 * and it's updated with the bonuses or penalties the user has*/
	public static function add_user_score( $user_id, $class_id,
																					$challenge_id, $points,
																				 $penalties_bonuses){
		global $db;
		$params=array(':user_id'=>$user_id, ':challenge_id'=>$challenge_id,
									':class_id'=>$class_id,	':points'=>$points,
									':penalties_bonuses'=>$penalties_bonuses);
		$sql="INSERT INTO user_score(user_id,challenge_id,class_id,points,penalties_bonuses)";
		$sql .= "VALUES (:user_id,:challenge_id,:class_id,:points,:penalties_bonuses)";
		$query = $db->query($sql,$params);
		if ($db->affectedRows($query)) {
			return true;
		} else {
			return false;
		}
	}
	public static function delete_user_score($id){
		global $db;
		$params=array(':id'=>$id);
		$sql = "DELETE FROM user_score WHERE id=:id";
		$query = $db->query($sql,$params);
		ClassChallenges::deleteAllMemberships($id);
		if ($db->affectedRows($query)) {
			return true;
		} else {
			return false;
		}
	}
	public static function update_user_score( $id, $user_id, $challenge_id,
																						$class_id, $points,
																						$penalties_bonuses){
		global $db;
		$params=array(':user_id'=>$user_id, ':challenge_id'=>$challenge_id,
									':class_id'=>$class_id,	':points'=>$points,
									':penalties_bonuses'=>$penalties_bonuses,':id'=>$id);
		$sql="UPDATE user_score SET user_id = :user_id,
																challenge_id = :challenge_id,
																class_id = :class_id,
																points = :points,
																penalties_bonuses= :penalties_bonuses
																WHERE id = :id";
		$query = $db->query($sql,$params);
		if ($db->affectedRows($query)) {
			return true;
		} else {
			return false;
		}
	}
  /**
	 * Returns the score with id $id
	 */
	public static function get_user_score($id){
		global $db;
		$params = array (':id' => $id );
		$sql = "SELECT * FROM user_score WHERE id= :id LIMIT 1";
		$result_array=self::findBySQL($sql,$params);
		return !empty($result_array)?array_shift($result_array):false;
	}
	/**
	 * Returns the score information for users with id = user_id
	 * or false if the id does not exist
	 */
	public static function get_scores_for_user($user_id){
		global $db;
		$params = array (':user_id' => $user_id );
		$sql = "SELECT * FROM user_score WHERE user_id= :user_id LIMIT 1";
		$result_array=self::findBySQL($sql,$params);
		return !empty($result_array)?$result_array:false;
		}
	/**
	 * Returns the scores for the challenge_id
	 * or false if the id does not exist
	 */
	public static function get_scores_for_challenge($challenge_id){
		global $db;
		$params = array (':challenge_id' => $challenge_id );
		$sql = "SELECT * FROM user_score WHERE challenge_id= :challenge_id LIMIT 1";
		$result_array=self::findBySQL($sql,$params);
		return !empty($result_array)?array_shift($result_array):false;
		}
	/**
	 * Returns the class scores
	 */
	public static function get_scores_for_class($class_id){
		global $db;
		$params = array (':class_id' => $class_id );
		$sql = "SELECT * FROM user_score WHERE class_id= :class_id LIMIT 1";
		$result_array=self::findBySQL($sql,$params);
		return !empty($result_array)?array_shift($result_array):false;
		}
		/**
	 * Returns the score information for the specific user in
	 * specific class for all challenges
	 */
	public static function get_scores_for_user_class($user_id, $class_id){
		global $db;
		$params = array (':user_id' => $user_id,
										 ':class_id' => $class_id);
		$sql = "SELECT * FROM user_score
						WHERE user_id= :user_id
						AND class_id= :class_id";
		$result_array=self::findBySQL($sql,$params);
		return !empty($result_array)?$result_array:false;
	}
	/**
	 * Returns the score information for the specific user in
	 * the specific class for the specific challenge
	 */
	public static function get_scores_for_user_class_challenge($user_id, $class_id, $challenge_id){
		global $db;
		$params = array (':user_id' => $user_id,
										 ':class_id' => $class_id,
										 ':challenge_id' => $challenge_id);
		$sql = "SELECT * FROM user_score
						WHERE user_id= :user_id
						AND class_id= :class_id
						AND challenge_id= :challenge_id";
		$result_array=self::findBySQL($sql,$params);
		return !empty($result_array)?array_shift($result_array):false;
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
		private static function findBySQL($sql,$params=NULL) {
		global $db;
		$result_set=$db->query($sql,$params);
		$object_array=array();
		while($row=$db->fetchArray($result_set)) {
			$object_array[]=self::instantiate($row);
		}
		return $object_array;
	}

}
 ?>
