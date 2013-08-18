<?php
/**
 *
 * Hackademic-CMS/controller/class.ChallengeMonitorController.php
 *
 * Hackademic User Menu Controller
 * Class for creating the frontend Main Menu
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
require_once(HACKADEMIC_PATH."model/common/class.Challenge.php");
require_once(HACKADEMIC_PATH."model/common/class.User.php");
require_once(HACKADEMIC_PATH."model/common/class.Session.php");
require_once(HACKADEMIC_PATH."model/common/class.ChallengeAttempts.php");
require_once(HACKADEMIC_PATH."admin/model/class.ClassMemberships.php");
require_once(HACKADEMIC_PATH."admin/model/class.ClassChallenges.php");
require_once(HACKADEMIC_PATH."model/common/class.UserHasChallengeToken.php");
require_once(HACKADEMIC_PATH."controller/class.HackademicController.php");
require_once(HACKADEMIC_PATH."model/common/class.ScoringRule.php");
require_once(HACKADEMIC_PATH."model/common/class.UserScore.php");

if(!defined('EXPERIMENTATION_BONUS_ID')){
	define('EXPERIMENTATION_BONUS_ID', "experimentation_bonus");
	define('TIME_LIMIT_PENALTY_ID', "time_limit_penalty");
	define('RPS_PENALTY_ID', "request_per_second_penalty");
	define('UA_PENALTY_ID', "banned_user_agent_penalty");
	define('MULT_SOL_BONUS_ID', "multiple_solution_bonus");
	define('TOTAL_ATTEMPT_PENALTY_ID', "total_attempt_penalty");
	define('FTS_PENALTY_ID', "first_try_penalty");
}
class ChallengeMonitorController {

    public function go() {
        // Check Permissions
    }

    public function get_pkg_name(){
		$url = $_SERVER['REQUEST_URI'];
        $url_components = explode("/", $url);
        $count_url_components = count($url_components);
        for ($i=0; $url_components[$i] != "challenges"; $i++);
			$pkg_name = $url_components[$i+1];
		return $pkg_name;
	}
    public function start($user_id = null, $chid = null, $class_id = null, $token = null,
						  $status = 'CHECK'){
		if(!isset($_SESSION))
			session_start();

		if($status == CHALLENGE_INIT && !isset($_SESSION['init'])){
			$_SESSION['chid'] = $chid;
			$_SESSION['token'] = $token;
			$_SESSION['user_id'] = $user_id;
			$_SESSION['pkg_name'] = $this->get_pkg_name();
			$_SESSION['class_id'] = $class_id;
			$this->calc_score(-1, $user_id, $chid, $class_id);
			$_SESSION['init'] = true;
			//var_dump($_SESSION);
			return;
		}
		$pkg_name = $this->get_pkg_name();
		//echo"<p>";var_dump($token);echo "</p>";
		//echo"<p>";var_dump($_SESSION['token']);echo "</p>";
		if(!isset($_SESSION['chid']))
			$_SESSION['chid'] = $chid;
		if(!isset($_SESSION['token']))
			$_SESSION['token'] = $token;
		if(!isset($_SESSION['user_id']))
			$_SESSION['user_id'] = $user_id;
		if(!isset($_SESSION['pkg_name']))
			$_SESSION['pkg_name'] = $pkg_name;
		if(!isset($_SESSION['class_id']))
			$_SESSION['class_id'] = $class_id;

		$pair = UserHasChallengeToken::findByPair($user_id,$chid,$token);

		/*If token is the one in the session then challenge must be the same*/
		if($_SESSION['token'] == $token)
		if($pkg_name != $_SESSION['pkg_name']  || $_SESSION['chid'] != $chid){
			error_log("HACKADEMIC::ChallengeMonitorController::RIGHT token WRONG CHALLENGE it's ".$pkg_name.' it should be '.$_SESSION['pkg_name']);
			header("Location: ".SITE_ROOT_PATH);
			die();
		}
		/* If token changed AND the challenge changed AND its a valid token
		 * for that challenge then we are in a new challenge
		 */
		if($_SESSION['token'] != $token && $token!=null)
			if($pkg_name != $_SESSION['pkg_name']  || $_SESSION['chid'] != $chid || $_SESSION['user_id'] != $user_id){
				if($pair->token == $token){
					$_SESSION['chid'] = $chid;
					$_SESSION['token'] = $token;
					$_SESSION['pkg_name'] = $pkg_name;
					$_SESSION['user_id'] = $user_id;
					$this->calc_score(-1, $user_id, $chid, $class_id);
					$_SESSION['init'] = false;
					$_SESSION['class_id'] = $class_id;
				}
			}else{
				//var_dump($_SESSION);//die();
				error_log("HACKADEMIC::ChallengeMonitorController::Hijacking attempt? ".$_SESSION['pkg_name']);
				header("Location: ".SITE_ROOT_PATH);
				die();
			}

		/*echo"<p>";var_dump($pair);echo "</p>";
		echo"<p>";var_dump($token);echo "</p>";
		echo"<p>";var_dump($_SESSION['token']);echo "</p>";
		*/
		if($pair && $pair->token != $token){
			error_log("HACKADEMIC::ChallengeMonitorController::pair->token != $token".$pair->token);
			header("Location: ".SITE_ROOT_PATH);
			die();

		}
	}
    public function update($status, $request) {

		if( !empty($request) ){
			$user_id = $request['user_id'];
			$chid = $request['id'];
			$class_id = $request['class_id'];
			$token = $request['token'];
		}else{
			$user_id = null;
			$chid = null;
			$class_id = null;
			$token = null;
		}
		$this->start($user_id,$chid, $class_id, $token,$status);
		/*
		 * if status == init we only need to update the SESSION var which we do in start
		 */
		if($status == CHALLENGE_INIT){
			return;
		}
		if ($user_id == null)
			$user_id = $_SESSION['user_id'];
		if ($chid == null)
			$chid = $_SESSION['chid'];
		if ($token == null)
			$token = $_SESSION['token'];
		if ($class_id == null)
			$class_id = $_SESSION['class_id'];

		$this->calc_score($status, $user_id, $chid, $class_id);

        $username = $user_id;
        $url = $_SERVER['REQUEST_URI'];
        $url_components = explode("/", $url);
        $count_url_components = count($url_components);
        for ($i=0; $url_components[$i] != "challenges"; $i++);
		$pkg_name = $url_components[$i+1];
        $user = User::findByUserName($username);
        $challenge = Challenge::getChallengeByPkgName($pkg_name);
        if($user)
           $user_id = $user->id;
         $challenge_id = $challenge->id;
         if (!ChallengeAttempts::isChallengeCleared($user_id, $challenge_id)) {
						ChallengeAttempts::addChallengeAttempt($user_id, $challenge_id, $class_id, $status);
          }
   }
	/**
	 * Called for unsuccesful attempt, updates the current score for the user
	 * Called on success calculates the total score for the user
	 */
	public function calc_score($status = 0, $user_id, $challenge_id, $class_id){
		if (!isset($_SESSION['rules']) || !is_array($_SESSION['rules'])|| $_SESSION['rules'] == ""){
			$rule = ScoringRule::get_scoring_rule_by_challenge_class_id($challenge_id, $class_id);

			/* if challenge has not scoring rules load up the default ones*/
			if( $rule === false){
				$rule = ScoringRule::get_scoring_rule(DEFAULT_RULES_ID);
			}

			/* Add the rules to the session */
			$_SESSION['rules'] =  (array)$rule;
		}
			/* load the rules and the current score*/
			$attempt_cap = $_SESSION['rules']['attempt_cap'];
			$attempt_cap_penalty = $_SESSION['rules']['attempt_cap_penalty'];

			$t_limit = $_SESSION['rules']['time_between_first_and_last_attempt'];
			$reset_time = $_SESSION['rules']['time_reset_limit_seconds'];
			$time_penalty = $_SESSION['rules']['time_penalty'];

			$rps_limit = $_SESSION['rules']['request_frequency_per_minute'];
			$rps_penalty = $_SESSION['rules']['request_frequency_penalty'];

			$exp_bonus = $_SESSION['rules']['experimentation_bonus'];
			$mult_sol_bonus = $_SESSION['rules']['multiple_solution_bonus'];

			$banned_user_agents = $_SESSION['rules']['banned_user_agents'];
			$banned_ua_penalty =  $_SESSION['rules']['banned_user_agents_penalty'];

			$base_score = $_SESSION['rules']['base_score'];

			$first_try_limit = $_SESSION['rules']['first_try_solves'];
			$fts_penalty = $_SESSION['rules']['penalty_for_many_first_try_solves'];

			$current_score = UserScore::get_scores_for_user_class_challenge($user_id, $class_id, $challenge_id);

			if ($current_score === false){
				$current_score = UserScore::get_scores_for_user_class_challenge($user_id, $class_id, $challenge_id);
				$_SESSION['current_score'] = (array)$current_score;
			}
		if ($status == -1){

			foreach($_SESSION['rules'] as $key=>$value)
				unset($_SESSION['rules'][$key]);
			unset($_SESSION['rules']);


			if ($current_score === false){
				UserScore::add_user_score( $user_id, $class_id, $challenge_id, 0, "");
				$current_score = UserScore::get_scores_for_user_class_challenge($user_id, $class_id, $challenge_id);
			}
			$_SESSION['f_atempt'] = date("Y-m-d H:i:s");
			$_SESSION['last_attempt'] = date("Y-m-d H:i:s");
			$_SESSION['total_attempt_count'] = 0;

			$_SESSION['rps_attempt_count'] = 1;
			$_SESSION['rps_min_start'] = microtime(true);
			$_SESSION['last_attempt_microsecs'] = microtime(true);

			$_SESSION['ua'] = $_SERVER['HTTP_USER_AGENT'];

			return;

		}elseif ($status == 0){
			if (ChallengeAttempts::isChallengeCleared($user_id, $challenge_id, $class_id)){
				if (strpos($current_score->penalties_bonuses,EXPERIMENTATION_BONUS_ID) === false && $exp_bonus > 0){
					/* apply experimentation bonus*/
					$current_score->points += $exp_bonus;
					$current_score->penalties_bonuses .= EXPERIMENTATION_BONUS_ID;
					$current_score->penalties_bonuses .= ",";
				}
			}

			if ($_SESSION['total_attempt_count'] > $attempt_cap){
				/* apply total attempt penalty*/
				if(strpos($current_score->penalties_bonuses,TOTAL_ATTEMPT_PENALTY_ID) === false && $attempt_cap_penalty > 0){
					$current_score->points -= $attempt_cap_penalty;
					$current_score->penalties_bonuses .= TOTAL_ATTEMPT_PENALTY_ID;
					$current_score->penalties_bonuses .= ",";
				}
			}
			$_SESSION['total_attempt_count']++;

			$t_since_first = strtotime(date("Y-m-d H:i:s")) - strtotime($_SESSION['f_atempt']);
			if ($t_since_first >= $reset_time)
				$t_since_first = 0;
			if ($t_since_first >= $t_limit){
				/* apply total time penalty */
				if(strpos($current_score->penalties_bonuses,TIME_LIMIT_PENALTY_ID) === false && $time_penalty > 0){
					$current_score->points -= $time_penalty;
					$current_score->penalties_bonuses .= TIME_LIMIT_PENALTY_ID;
					$current_score->penalties_bonuses .= ",";
				}
			}
			$diff = microtime(true) - $_SESSION['rps_min_start'];
			$_SESSION['last_attempt_microsecs'] = microtime(true);
			if ($diff >= MICROSECS_IN_MINUTE){
				if ($_SESSION['rps_attempt_count'] >= $rps_limit){
					/* apply requests per minute penalty*/
					if(strpos($current_score->penalties_bonuses,RPS_PENALTY_ID) === false && $rps_penalty > 0){
						$current_score->points -= $rps_penalty;
						$current_score->penalties_bonuses .= RPS_PENALTY_ID;
						$current_score->penalties_bonuses .= ",";
					}
				}
				$_SESSION['rps_min_start'] = microtime(true);
				$_SESSION['rps_attempt_count'] = 0;
			}else{
				$_SESSION['rps_attempt_count']++;
			}
			$ua_check = strpos($banned_user_agents, $_SERVER['HTTP_USER_AGENT']);
			if ($ua_check != false){
				/* apply user agent penalty*/
				if(strpos($current_score->penalties_bonuses,UA_PENALTY_ID) === false && $banned_ua_penalty > 0){
					$current_score->points -= $banned_ua_penalty;
					$current_score->penalties_bonuses .= UA_PENALTY_ID;
					$current_score->penalties_bonuses .= ",";
				}

			}
		}elseif ($status == 1){
			$current_score->points += $base_score;

			if (ChallengeAttempts::isChallengeCleared($user_id, $challenge_id, $class_id)){
				/* apply multiple solutions bonus*/
				if(strpos($current_score->penalties_bonuses,MULT_SOL_BONUS_ID) === false && $mult_sol_bonus > 0){
					$current_score->points += $mult_sol_bonus;
					$current_score->penalties_bonuses .= MULT_SOL_BONUS_ID;
					$current_score->penalties_bonuses .= ",";
				}
			}else{
				/* 	get the tries from the database */
				$first = ChallengeAttempts::getUserFirstChallengeAttempt($user_id, $challenge_id, $class_id);
				$last_db = ChallengeAttempts::getUserLastChallengeAttempt($user_id, $challenge_id, $class_id);
				$last = date("Y-m-d H:i:s");
				$total_count = ChallengeAttempts::getUserTriesForChallenge($user_id, $challenge_id, $class_id);
				false === $total_count?$total_count = 0: $total_count;
				if($last_db !=false)
					$t_since_first = strtotime(date("Y-m-d H:i:s")) - strtotime($last_db->time);
				else
					$t_since_first = 0;

				if ($t_since_first >= $t_limit){
					/* apply time limit penalty */
					if(strpos($current_score->penalties_bonuses,TIME_LIMIT_PENALTY_ID) === false && $time_penalty > 0){
						$current_score->points -= $time_penalty;
						$current_score->penalties_bonuses .= TIME_LIMIT_PENALTY_ID;
						$current_score->penalties_bonuses .= ",";
					}
				}
				$diff = microtime(true) - $_SESSION['rps_min_start'];
				if ($diff >= MICROSECS_IN_MINUTE){
					if ($_SESSION['rps_attempt_count'] >= $rps_limit){
						/* apply requests per second penalty*/
						if(strpos($current_score->penalties_bonuses,RPS_PENALTY_ID) === false && $rps_penalty > 0){
							$current_score->points -= $rps_penalty;
							$current_score->penalties_bonuses .= RPS_PENALTY_ID;
							$current_score->penalties_bonuses .= ",";
						}
					}
					$_SESSION['rps_min_start'] = microtime(true);
					$_SESSION['rps_attempt_count'] = 0;
				}else{
					/** if user solved it in under a minute
					 * 	(or not a full minute has  passed since last reset)
					 */
					$t_since_last_micro = microtime(true) - $_SESSION['last_attempt_microsecs'];
						if ($_SESSION['rps_attempt_count'] >= $rps_limit){
							/* apply requests per second penalty*/
							if(strpos($current_score->penalties_bonuses,RPS_PENALTY_ID) === false && $rps_penalty > 0){
								$current_score->points -= $rps_penalty;
								$current_score->penalties_bonuses .= RPS_PENALTY_ID;
								$current_score->penalties_bonuses .= ",";
							}
						}
				}
				if ( 1 + $total_count >= $attempt_cap){
					/* apply total attempt penalty*/
					if(strpos($current_score->penalties_bonuses,TOTAL_ATTEMPT_PENALTY_ID) === false && $attempt_cap > 0){
						$current_score->points -= $attempt_cap_penalty;
						$current_score->penalties_bonuses .= TOTAL_ATTEMPT_PENALTY_ID;
						$current_score->penalties_bonuses .= ",";
					}
				}
				$count_first_try = ChallengeAttempts::getCountOfFirstTrySolves($user_id, $class_id);
				if($_SESSION['total_attempt_count'] == 0)
					$count_first_try++;
				if( $first_try_limit != 0 && $count_first_try >= $first_try_limit){
					/* apply cheater penalty */
					if(strpos($current_score->penalties_bonuses,FTS_PENALTY_ID) === false && $fts_penalty > 0){
						$current_score->points -= $fts_penalty;
						$current_score->penalties_bonuses .= FTS_PENALTY_ID;
						$current_score->penalties_bonuses .= ",";
					}
				}
			}
		}
	UserScore::update_user_score( $current_score->id, $user_id,
								  $challenge_id, $class_id,
								  $current_score->points,
								  $current_score->penalties_bonuses);
	}

}
