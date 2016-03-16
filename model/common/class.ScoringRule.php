<?php
/**
 *
 * Hackademic-CMS/model/common/class.ChallengeScoring.php
 *
 * Hackademic ScoringRuleBackend Class
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

class ScoringRule{

	public $id;
	public $challenge_id;
	public $class_id;
	public $attempt_cap;
	public $attempt_cap_penalty;
	public $time_between_first_and_last_attempt;
	public $time_penalty;
	public $time_reset_limit_seconds;
	public $request_frequency_per_minute;
	public $request_frequency_penalty;
	public $experimentation_bonus;
	public $multiple_solution_bonus;
	public $banned_user_agents;
	public $base_score;
	public $banned_user_agents_penalty;
	public $first_try_solves;
	public $penalty_for_many_first_try_solves;

    /**
	 * Returns the details of the scoring rule with id $id
	 * or false if the id does not exist
	 */
	public static function get_scoring_rule($id){
		global $db;
		$params = array (':id' => $id );
		$sql = "SELECT * FROM scoring_rule WHERE id= :id LIMIT 1";
		$result_array=self::findBySQL($sql,$params);
		return !empty($result_array)?array_shift($result_array):false;
	}
	/**
	 * Returns the details of the scoring rules of the challenge with id
	 * $id or false if the id does not exist
	 */
	public static function get_scoring_rule_by_challenge_id($challenge_id){
		global $db;
		$params = array (':challenge_id' => $challenge_id );
		$sql = "SELECT * FROM scoring_rule WHERE challenge_id= :challenge_id LIMIT 1";
		$result_array=self::findBySQL($sql,$params);
		return !empty($result_array)?array_shift($result_array):false;
	}
	/**
	 * Returns the details of the scoring rules for every challenge in
	 * the class with id $id or false if the id does not exist
	 */
	public static function get_scoring_rule_by_class_id($class_id){
		global $db;
		$params = array (':class_id' => $class_id );
		$sql = "SELECT * FROM scoring_rule WHERE class_id= :class_id LIMIT 1";
		$result_array=self::findBySQL($sql,$params);
		return !empty($result_array)?array_shift($result_array):false;
	}
	/**
	 * Returns the details of the scoring rule with challenge_id
	 *  $challenge_id and class_id $class_id or false if
	 *  the ids do not exist.
	 */
	public static function get_scoring_rule_by_challenge_class_id($challenge_id, $class_id){
		global $db;
		$params = array (':challenge_id' => $challenge_id,
						 ':class_id' => $class_id);
		$sql = "SELECT * FROM scoring_rule WHERE challenge_id= :challenge_id
				AND class_id = :class_id LIMIT 1";
		$result_array=self::findBySQL($sql,$params);
		return !empty($result_array)?array_shift($result_array):false;
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
	public static function getRuleSummary($rule){
		$result = "";
		$i = 0;
		if($rule != false){
			foreach($rule as $attr=>$value){
				if($value > 0)
					if(	$attr != 'id'
							&& $attr != 'challenge_id'
							&& $attr != 'class_id'
							&& $attr != 'banned_user_agents'
							&& $attr != 'base_score'){
								if($i != 0){
									$result .=", ";
							}
						$result .= $attr;	$i++;
					}
			}
		}
		return $result;
	}
	public static function isDefaultRule($rule){
		$count = 0;
					if(!is_object($rule)){
						error_log("isDefaultRule:Variable not an object");
						return;
					}
					if($rule->attempt_cap == 0)
						$count++;
					if($rule->attempt_cap_penalty == 0)
						$count++;
					if($rule->time_between_first_and_last_attempt == 0)
						$count++;
					if($rule->time_reset_limit_seconds == 0)
						$count++;
					if($rule-> request_frequency_per_minute == 0)
						$count++;
					if($rule-> request_frequency_penalty == 0)
						$count++;
					if($rule->experimentation_bonus == 0)
						$count++;
					if($rule->multiple_solution_bonus == 0)
						$count++;
					if($rule->banned_user_agents == 0)
						$count++;
					if($rule->base_score == 0)
						$count++;
					if($rule->banned_user_agents_penalty == 0)
						$count++;
					if($rule->first_try_solves == 0)
						$count++;
					if($rule->penalty_for_many_first_try_solves == 0)
						$count++;

		return $count == 13?true:false;
	}
}
 ?>
