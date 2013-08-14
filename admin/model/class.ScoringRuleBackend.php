<?php
/**
 *
 * Hackademic-CMS/model/common/class.ChallengeScoring.php
 *
 * Hackademic ScoringRulesBackend Class
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
require_once(HACKADEMIC_PATH."model/common/class.ScoringRule.php");

class ScoringRuleBackend extends ScoringRule{

	/**
	 * Adds a new scoring rule
	 */
	public static function add_scoring_rule(	$challenge_id,
																						$class_id,
																						$attempt_cap,
																						$attempt_cap_penalty,
																						$time_between_first_and_last_attempt,
																						$time_penalty,
																						$time_reset_limit_seconds,
																						$request_frequency_per_minute,
																						$request_frequency_penalty,
																						$experimentation_bonus,
																						$multiple_solution_bonus,
																						$banned_user_agents,
																						$base_score,
																						$banned_user_agents_penalty,
																						$first_try_solves,
																						$penalty_for_many_first_try_solves){
	global $db;
		$params=array( ':challenge_id' => $challenge_id,
				':class_id' => $class_id,
				':attempt_cap' => $attempt_cap,
				':attempt_cap_penalty' => $attempt_cap_penalty,
				':time_between_first_and_last_attempt' => $time_between_first_and_last_attempt,
				':time_penalty' => $time_penalty,
				':time_reset_limit_seconds' => $time_reset_limit_seconds,
				':request_frequency_per_minute' => $request_frequency_per_minute,
				':request_frequency_penalty' => $request_frequency_penalty,
				':experimentation_bonus' => $experimentation_bonus,
				':multiple_solution_bonus' => $multiple_solution_bonus,
				':banned_user_agents' => $banned_user_agents,
				':base_score' => $base_score,
				':banned_user_agents_penalty' => $banned_user_agents_penalty,
				':first_try_solves' => $first_try_solves,
				':penalty_for_many_first_try_solves' => $penalty_for_many_first_try_solves
			     );

		$sql="INSERT INTO scoring_rule ( challenge_id ,  class_id ,  attempt_cap ,  attempt_cap_penalty ,  time_between_first_and_last_attempt ,  time_penalty ,  time_reset_limit_seconds ,  request_frequency_per_minute ,  request_frequency_penalty ,  experimentation_bonus ,  multiple_solution_bonus ,  banned_user_agents ,  banned_user_agents_penalty ,  base_score ,  first_try_solves ,  penalty_for_many_first_try_solves )";
		$sql .= "VALUES (:challenge_id,:class_id,:attempt_cap,:attempt_cap_penalty,:time_between_first_and_last_attempt,:time_penalty,:time_reset_limit_seconds,:request_frequency_per_minute,:request_frequency_penalty,:experimentation_bonus,:multiple_solution_bonus,:banned_user_agents,:base_score,:banned_user_agents_penalty,:first_try_solves,:penalty_for_many_first_try_solves)";
		$query = $db->query($sql,$params);
		if ($db->affectedRows($query)) {
			return true;
		} else {
			return false;
		}
	}
	/**
	 * Updates an existing rule
	 */
	public static function update_scoring_rule($id, $challenge_id, $class_id,
											   $attempt_cap, $attempt_cap_penalty,
											   $time_between_first_and_last_attempt,
											   $time_penalty, $time_reset_limit_seconds,
											   $request_frequency_per_minute,	$request_frequency_penalty,
											   $experimentation_bonus,	$multiple_solution_bonus,
											   $banned_user_agents, $base_score,$banned_user_agents_penalty,
												$first_try_solves, $penalty_for_many_first_try_solves){
		global $db;
		$params=array(':id'=>$id,
				':challenge_id' => $challenge_id,
				':class_id' => $class_id,
				':attempt_cap' => $attempt_cap,
				':attempt_cap_penalty' => $attempt_cap_penalty,
				':time_between_first_and_last_attempt' => $time_between_first_and_last_attempt,
				':time_penalty' => $time_penalty,
				':time_reset_limit_seconds' => $time_reset_limit_seconds,
				':request_frequency_per_minute' => $request_frequency_per_minute,
				':request_frequency_penalty' => $request_frequency_penalty,
				':experimentation_bonus' => $experimentation_bonus,
				':multiple_solution_bonus' => $multiple_solution_bonus,
				':banned_user_agents' => $banned_user_agents,
				':base_score' => $base_score,
				':banned_user_agents_penalty' => $banned_user_agents_penalty,
				':first_try_solves' => $first_try_solves,
				':penalty_for_many_first_try_solves' => $penalty_for_many_first_try_solves
			     );

		$sql="UPDATE  scoring_rule  SET
						challenge_id  = :challenge_id,
						class_id  = :class_id,
						attempt_cap  = :attempt_cap,
						attempt_cap_penalty = :attempt_cap_penalty,
						time_between_first_and_last_attempt  = :time_between_first_and_last_attempt,
						time_penalty  = :time_penalty,
						time_reset_limit_seconds  = :time_reset_limit_seconds,
						request_frequency_per_minute  = :request_frequency_per_minute,
						request_frequency_penalty  = :request_frequency_penalty,
						experimentation_bonus  = :experimentation_bonus,
						multiple_solution_bonus  = :multiple_solution_bonus,
						banned_user_agents  = :banned_user_agents,
						banned_user_agents_penalty  = :banned_user_agents_penalty,
						base_score  = :base_score,
						first_try_solves  = :first_try_solves,
						penalty_for_many_first_try_solves  = :penalty_for_many_first_try_solves
						WHERE id =:id";
		$query = $db->query($sql,$params);
		if ($db->affectedRows($query)) {
			return true;
		} else {
			return false;
		}


	}
	/**
	 * Deletes the default scoring rule
	 */
	public static function delete_scoring_rule($id){
		global $db;
		$params = array(':id'=>$id);
		$sql = 'DELETE FROM scoring_rule WHERE id = :id';
		$query = $db->query($sql,$params);
		if ($db->affectedRows($query)) {
			return true;
		} else {
			return false;
		}
	}
}
 ?>
