<?php
/**
 *
 * Hackademic-CMS/model/common/class.ChallengeAttempts.php
 *
 * Hackademic Challenge Attempts Class
 * Class for Hackademic's Challenge Attempts Object
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
class ChallengeAttempts {
	public $id;
	public $user_id;
	public $challenge_id;
	public $class_id;
	public $time;
	public $status;
	public $tries;//total_attempts;
	//public $dummy;//dummy class var for hacks

	/**
	 * Adds a challenge attempt with timestamp
	 * and increases the total counter of tries for the challenge
	 * @returns: true on succesful update
	 * 			 false on error
	 */
	public static function addChallengeAttempt($user_id, $challenge_id, $class_id, $status){
		global $db;

		$time = date("Y-m-d H:i:s");
		$params=array(':user_id' => $user_id,
									':challenge_id' => $challenge_id,
									':class_id' => $class_id,
									':time' => $time,
									':status' => $status);
		$sql="INSERT INTO challenge_attempts(user_id, challenge_id, class_id, time, status)";
		$sql .= "VALUES (:user_id, :challenge_id, :class_id, :time, :status)";
		$query = $db->query($sql,$params);
		if ($db->affectedRows($query)) {
			return self::increaseChallengeAttemptCount($user_id,
																								 $challenge_id,
																								 $class_id);
		} else {
			return false;
		}
	}

	/**
	 * Adds another challenge attempt or increases the existing ones
	 */
	public static function increaseChallengeAttemptCount($user_id,
																											 $challenge_id,
																											 $class_id){
		global $db;
		$params=array(':user_id' => $user_id,
									':challenge_id' => $challenge_id,
									':class_id' => $class_id,
									':tries' => 1
									);
		$sql = "INSERT INTO challenge_attempt_count
				(user_id, challenge_id, class_id, tries)
				VALUES (:user_id, :challenge_id, :class_id, :tries)
				ON DUPLICATE KEY UPDATE tries = tries + 1";
		$query = $db->query($sql, $params);
		if ($db->affectedRows($query)) {
			return true;
		} else {
			return false;
		}
	}

	public static function deleteChallengeAttemptByUser($user_id){
		global $db;
		$params=array(':user_id' => $user_id);
		$sql = "DELETE FROM challenge_attempts WHERE user_id=:user_id";
		$query = $db->query($sql,$params);
		if ($db->affectedRows($query)) {
			self::deleteChallengeAttemptCountByUser($user_id);
			return true;
		} else {
			return false;
		}
	}

	public static function deleteChallengeAttemptCountByUser($user_id){
		global $db;
		$params=array(':user_id' => $user_id);
		$sql = "DELETE FROM challenge_attempt_count WHERE user_id=:user_id";
		$query = $db->query($sql,$params);

	}

	public static function deleteChallengeAttemptByChallenge($challenge_id){
		global $db;
		$params=array(':challenge_id' => $challenge_id);
		$sql = "DELETE FROM challenge_attempts WHERE challenge_id=:challenge_id";
		$query = $db->query($sql,$params);
		if ($db->affectedRows($query)) {
			self::deleteChallengeAttemptCountByChallenge($challenge_id);
			return true;
		} else {
			return false;
		}
	}

	public static function deleteChallengeAttemptCountByChallenge($challenge_id){
		global $db;
		$params=array(':challenge_id' => $challenge_id);
		$sql = "DELETE FROM challenge_attempt_count WHERE challenge_id=:challenge_id";
		$query = $db->query($sql,$params);
	}

	public static function getChallengeAttemptDetails($user_id) {
		global $db;
		$params=array(':user_id' => $user_id);
		$sql = "SELECT challenge_id,status,id,pkg_name FROM challenges INNER JOIN challenge_attempts";
		$sql .=" WHERE challenge_attempts.challenge_id=challenges.id AND challenge_attempts.user_id=:user_id ";
		$result_array=self::findBySQL($sql,$params);
		// return !empty($result_array)?array_shift($result_array):false;
		return $result_array;
	}

	public static function isChallengeCleared($user_id, $challenge_id, $class_id = '*') {
		global $db;
		$params = array(
			':user_id' => $user_id,
			':challenge_id' => $challenge_id,
			':class_id' => $class_id
		);
		$sql = "SELECT * FROM challenge_attempts
				WHERE user_id = :user_id
				AND	challenge_id = :challenge_id
				AND class_id = :class_id
				AND status = 1;";
		$query = $db->query($sql, $params);
		if ($db->numRows($query)) {
			return true;
		} else {
			return false;
		}
	}
	public static function getUserProgress($user_id, $class_id) {
		global $db;
		$params = array(':user_id' => $user_id, ':class_id' => $class_id );

		/*Count the attempts for all challenges*/
		$sql = "SELECT challenge_id, count(*) as tries FROM challenge_attempts
				WHERE user_id = :user_id AND class_id = :class_id GROUP BY challenge_id;";
		$result_array = self::findBySQL($sql,$params);

		/* Get more data for the completed ones*/
		$sql2 = "SELECT DISTINCT challenge_id, time FROM challenge_attempts
				 WHERE user_id = :user_id AND class_id = :class_id AND status = 1;";
		$result_2 = self::findBySQL($sql2,$params);

		//var_dump($result_array);echo'</p> 2:</p>';var_dump($result_2);echo'</p>';
		foreach($result_array as $element){
			foreach($result_2 as $el){
				if($element->challenge_id === $el->challenge_id){
					$element->time = $el->time;
					$element->status = 1;
					//unset($result_2[$el]);
				}
			}
		}
		//var_dump($result_array);
		//var_dump(!empty($result_array)?$result_array:false);
		return !empty($result_array)?$result_array:false;
	}
/*	public static function getTotalAttemptsOfUserForEachChallenge($user_id) {
		global $db;
		self::getUserProgress($user_id);

		$params = array(':user_id' => $user_id );
		$sql = "SELECT challenge_id, count(*) as count FROM challenge_attempts ";
		$sql .= " WHERE user_id = :user_id GROUP BY challenge_id;";
		$result_array = self::findBySQL($sql,$params);
		//var_dump(!empty($result_array)?$result_array:false);
		return !empty($result_array)?$result_array:false;
	}

	public static function getClearedChallenges($user_id) {
		global $db;
		$sql = "SELECT DISTINCT challenge_id, time FROM challenge_attempts ";
		$sql .= " WHERE user_id = $user_id AND status = 1;";
		$query = $db->query($sql);
		$result_array = self::findBySQL($sql,$params);
		//var_dump(!empty($result_array)?$result_array:false);
		return !empty($result_array)?$result_array:false;
	}
*/

	/**
	 *  Returns the first try the user made for a particular challenge
	 *  for a class or false if the user hasn't tried the challenge
	 */
	public static function getUserFirstChallengeAttempt($user_id, $challenge_id, $class_id){
		global $db;

		$params = array(':user_id' => $user_id,
						':challenge_id' => $challenge_id,
						':class_id' => $class_id);
		$sql = ' SELECT * FROM challenge_attempts
					WHERE user_id = :user_id
					AND challenge_id = :challenge_id
					AND class_id = :class_id
					ORDER BY time ASC LIMIT 1;';
		$result_array = self::findBySQL($sql, $params);
		return !empty($result_array)?array_shift($result_array):false;
	}
	/**
	 *  Returns the last try the user made for a particular challenge
	 *  for a class or false if the user hasn't tried the challenge
	 */
	public static function getUserLastChallengeAttempt($user_id, $challenge_id, $class_id){
		global $db;

		$params = array(':user_id' => $user_id,
						':challenge_id' => $challenge_id,
						':class_id' => $class_id);
		$sql = ' SELECT * FROM challenge_attempts
					WHERE user_id = :user_id
					AND challenge_id = :challenge_id
					AND class_id = :class_id
					ORDER BY time DESC LIMIT 1;';
		$result_array = self::findBySQL($sql, $params);
		return !empty($result_array)?array_shift($result_array):false;
	}
	/**
	 * Returns the user's tries for the challenge
	 */
	public static function getUserTriesForChallenge($user_id, $challenge_id, $class_id){
		global $db;

		$params = array(':user_id' => $user_id,
										':challenge_id' => $challenge_id,
										':class_id' => $class_id);
		$sql = ' SELECT tries FROM  challenge_attempt_count
							WHERE user_id = :user_id
							AND challenge_id = :challenge_id
							AND class_id = :class_id';
		$result = self::findBySQL($sql, $params);
		if(!empty($result))
			$result = $result[0]->tries;
		else $resutl = NULL;

		return $result!= NULL?$result:false;
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
	public static function getUniversalRankings($class_id = NULL) {
		global $db;
		$params = array(':class_id' => $class_id );

		$sql = "SELECT count(*) as tries, user_id, users.username
							FROM challenge_attempts LEFT JOIN users ON
					users.id = user_id WHERE status = 1 ";
		if ($class_id) {
			$sql .= "AND challenge_id IN (SELECT id as challenge_id
					 FROM class_challenges WHERE class_id = :class_id)";
		}
		//$sql .= "ORDER BY count(*) DESC, time LIMIT 100;";

		//var_dump($sql);
		$query = $db->query($sql);
		$result_array = array();
		while($row=$db->fetchArray($query)) {
			array_push($result_array, $row);
		}
		return $result_array;
	}
	/**
	 * Returns how many challenges have been solved by the user
	 * with id $user_id on the first try.
	 * */
	public static function getCountOfFirstTrySolves($user_id, $class_id){
		global $db;

		$params = array(':user_id' => $user_id,
										':class_id' => $class_id);
		$sql = "SELECT count(*) as tries
						FROM challenge_attempt_count,  challenge_attempts
						WHERE challenge_attempt_count.user_id = :user_id
						AND challenge_attempt_count.class_id =:class_id
						AND challenge_attempt_count.tries = 1
						AND challenge_attempts.user_id = challenge_attempt_count.user_id
						AND challenge_attempts.challenge_id = challenge_attempt_count.challenge_id
						AND challenge_attempts.status = 1;";
		$result = self::findBySQL($sql, $params);
		return !empty($result_array)?array_shift($result_array):0;
	}
	public static function getClasswiseRankings($class_id) {
		global $db;

		$params = array(':class_id' => $class_id );

		//get users belonging to class who have tried challenges belonging to class
		$sql = "SELECT DISTINCT class_memberships.user_id, class_challenges.challenge_id
				  FROM class_memberships, class_challenges
				  WHERE class_memberships.class_id = class_challenges.class_id
				  AND class_challenges.class_id = :class_id
				  AND user_id
					IN (SELECT user_id FROM challenge_attempts
						WHERE challenge_attempts.user_id =  class_memberships.user_id
						AND challenge_attempts.challenge_id = class_challenges.challenge_id)";
		$query = $db->query($sql, $params);
		$result_array = array();
		while($row=$db->fetchArray($query)) {
			array_push($result_array, $row);
		}

		$score = array();
		//for each user,challenge pair check if the user has solved the challenge
			$score_q = "SELECT count(*) as tries, user_id, users.username
							FROM challenge_attempts LEFT JOIN users ON
					users.id = user_id WHERE status = 1 AND user_id = :user_id AND challenge_id = :challenge_id";

		foreach($result_array as $row){

			$user_id = $row['user_id'];
			$challenge_id = $row['challenge_id'];
			$params = array(':user_id' => $user_id, ':challenge_id' => $challenge_id);
			$result = $db->query($score_q,$params);

			//echo'</p>'.$user_id." ".$challenge_id;echo'</p>';var_dump($row);
			$res = array();
			while($res=$db->fetchArray($result)) {
				$k = false;
				if(!empty($score)){
					foreach($score as &$uscore){
						$k = array_search($res['user_id'],$uscore);
						if( false != $k){
							$uscore['tries'] = 1 + intval($uscore['tries']);
							break;
						}
						unset($uscore);
					}
				}
				if( false === $k){
						if($res['username']!=null)
					array_push($score, $res);
					}
			}
		}
		usort($score, array("ChallengeAttempts", "sort_count"));
		return $score;
	}
	static function sort_count($rankA, $rankB){

		if ($rankA['tries'] == $rankB['tries']) {
			return 0;
		}
    return ($rankA['tries'] < $rankB['tries']) ? 1 : -1;
	}
	public static function getScore($user_id, $challenge_id){
	global $db;
	$sql = "SELECT default_points, challenges.id, title
		FROM challenges, challenge_attempts
		WHERE challenge_attempts.challenge_id = {$challenge_id}
		AND challenge_attempts.user_id = {$user_id}
		AND STATUS =1
		AND challenge_attempts.challenge_id = challenges.id";

	}
}
