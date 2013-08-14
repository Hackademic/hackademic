<?php
/**
 *
 * Hackademic-CMS/model/common/class.Challenge.php
 *
 * Hackademic Challenge Class
 * Class for Hackademic's Challenge Object
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
require_once(HACKADEMIC_PATH."admin/model/class.ClassChallenges.php");
require_once(HACKADEMIC_PATH."model/common/class.Debug.php");

class Challenge {
	public $id;
	public $title;
	public $date_posted;
	public $pkg_name;
	public $description;
	public $author;
	public $category;
	public $visibility;
	public $availability;
	public $publish;
	public $solution;
	public $level;
	public $duration;

	public function doesChallengeExist($name){
		global $db;
		$params=array(':name' => $name);
		$sql = "SELECT * FROM challenges WHERE pkg_name = :name";
		$query = $db->query($sql,$params);
		$result = $db->numRows($query);
		if ($result) {
			return true;
		} else {
			return false;
		}
	}

	public static function getChallenge($id) {
		global $db;
		$params = array(
				':id' => $id
			       );
		$sql = "SELECT * FROM challenges WHERE id= :id LIMIT 1";
		$result_array=self::findBySQL($sql,$params);
		return !empty($result_array)?array_shift($result_array):false;
	}
	public static function getPublicChallenges(){
			global $db;
			$sql = "SELECT * FROM challenges WHERE availability = 'public' AND visibility = 'public'";
			$result_array=self::findBySQL($sql);
		return !empty($result_array)?array_shift($result_array):false;
	}
	public static function getChallengeByPkgName($pkg_name) {
		global $db;
		$params = array(
				':pkg_name' => $pkg_name
			       );
		$sql = "SELECT * FROM challenges WHERE pkg_name= :pkg_name LIMIT 1";
		$result_array=self::findBySQL($sql,$params);
		return !empty($result_array)?array_shift($result_array):false;
		//return $result_array;
	}

//get all Visible and solvable challenges
	public static function getChallengesFrontend($user_id) {
		global $db;
		$params=array(':user_id' => $user_id);
		$sql = "SELECT DISTINCT challenges.id, challenges.title,challenges.pkg_name, challenges.availability,
						class_challenges.class_id,
			CASE WHEN class_id IS NULL THEN 'False' ELSE 'True' END AS class
			FROM challenges
			LEFT JOIN class_challenges ON challenges.id = class_challenges.challenge_id
			WHERE challenges.publish =1 AND ("
	//		(visibility = 'public')
		/*	OR*/
	 ." (class_id IN(
			SELECT class_memberships.class_id AS class_id
			FROM class_memberships WHERE
			class_memberships.user_id = :user_id
					)
			   )
							)
			ORDER BY challenges.id
			";
		$result_array= self::findBySQL($sql,$params);

		$sql = "SELECT * FROM challenges WHERE visibility = 'public' AND availability = 'public'";
		$res_arr2 = self::findBySQL($sql);
		$result = array_udiff($res_arr2, $result_array, 'Challenge::compare_challenges');
		foreach( $result as $el)
			array_push($result_array,$el);
		return !empty($result_array)?$result_array:false;
	}
	/**
	 * Returns the challenges assigned to the user with user_id $user
	 * grouped by class_id
	 */
	public static function getChallengesAssigned($user) {
		global $db;
		$challenge_ids = ClassChallenges::getChallengesOfUser($user);

		$class_challenges = array();
		$class_ids = array();
		if( $challenge_ids != FALSE){
			foreach ($challenge_ids as $chal) {
				if(!in_array($chal->class_id, $class_ids)){
					$class_ids[$chal->class_id] = $chal->class_id;
					$class_challenges[$chal->class_id] = array();
				}
 		    $challenge = self::getChallenge($chal->id);
		    if($chal->class_id != NULL)
					array_push($class_challenges[$chal->class_id],$challenge);
			}
		}else{
			return FALSE;
		}
		return $class_challenges;
	}

	public static function insertId() {
		global $db;
		return $db->insertId();
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

	public static function getNchallenges($start, $limit,$search=null,$category=null) {
		global $db;
		$params = array(
				':start' => $start,
				':limit' => $limit
			       );
		if ($search != null && $category != null) {
			$params[':search_string'] = '%'.$search.'%';
			switch ($category) {
				case "title":
					$sql = "SELECT * FROM challenges WHERE title LIKE :search_string LIMIT :start, :limit";
					break;
			}
		} else {
			$sql= "SELECT * FROM challenges LIMIT :start, :limit";
		}
		$result_array=self::findBySQL($sql,$params);
		return $result_array;
	}

	public static function getNumberOfChallenges($search=null,$category=null) {
		global $db;
		if ($search != null && $category != null) {
			$params[':search_string'] = '%'.$search.'%';
			switch ($category) {
				case "title":
					$sql = "SELECT COUNT(*) as num FROM challenges WHERE title LIKE :search_string ";
					break;
			}
			$query = $db->query($sql,$params);
		} else {
			$sql = "SELECT COUNT(*) as num FROM challenges";
			$query = $db->query($sql);
		}
		$result = $db->fetchArray($query);
		return $result['num'];
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

	private static function compare_challenges($ch_a, $ch_b) {

	//	var_dump($ch_a->id);var_dump($ch_b->id);echo '</br>';

		if ($ch_a->id === $ch_b->id){
		//	echo 'equal '. $ch_a->id.'</br>';
			return 0;
		}elseif($ch_a->id < $ch_b->id){
		//	echo 'less '. $ch_a->id.' '.$ch_b->id.'</br>';
			return -1;
		}elseif($ch_a->id > $ch_b->id){
		//	echo 'more '. $ch_a->id.' '.$ch_b->id.'</br>';
			return 1;
		}
	}
}
