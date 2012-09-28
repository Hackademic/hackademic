<?php
/**
 *
 * Hackademic-CMS/controller/class.ReadArticleController.php
 *
 * Hackademic Frontend Read Article Controller
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
require_once(HACKADEMIC_PATH."/admin/model/class.ClassMemberships.php");
require_once(HACKADEMIC_PATH."/admin/model/class.ClassChallenges.php");
require_once(HACKADEMIC_PATH."/model/common/class.Session.php");
require_once(HACKADEMIC_PATH."/model/common/class.User.php");
require_once(HACKADEMIC_PATH."/model/common/class.ChallengeAttempts.php");
require_once(HACKADEMIC_PATH."/controller/class.HackademicController.php");
require_once(HACKADEMIC_PATH."admin/model/class.UserChallenges.php");
require_once(HACKADEMIC_PATH."/model/common/class.UserScore.php");
require_once(HACKADEMIC_PATH."/model/common/class.Debug.php");

class ProgressReportController extends HackademicController{
	public function go() {
		$this->setViewTemplate('progressreport.tpl');
		if ($this->isAdmin() || $this->isTeacher()) {
			$this->addToView('search_box', true);
			if (isset($_GET['username'])) {
				$username = $_GET['username'];
			}
		} else {
			$username = Session::getLoggedInUser();
		}
		if (isset($username)) {
			$user = User::findByUserName($username);
			if (!$user) {
				$this->addErrorMessage("You provided an invalid username");
				return $this->generateView();
			} elseif ($user->type) {
				$this->addErrorMessage("Please select a student!");
				return $this->generateView();
			}
			//$challenges_of_user = UserChallenges::getChallengesOfUser($user->id);
			$data = array();
			$class_ids = array();
			$class_scores = array();
			$classes_of_user = ClassMemberships::getMembershipsOfUserObjects($user->id);

			foreach($classes_of_user as $class){
				$progress = ChallengeAttempts::getUserProgress($user->id, $class->id);
				$user_scores = UserScore::get_scores_for_user_class($user->id, $class->id);
				$class_challenges = ClassChallenges::getAllMemberships($class->id);
				$data = $this->build_scoring_info($class_challenges, $progress, $user_scores);
				$class_scores[$class->name] = $data;
				$class_ids[$class->name] = $class->id;
			}

			$this->addToView('data', $class_scores);
			$this->addToView('ids', $class_ids);
		} else {
			$this->addErrorMessage("Please select a student to see his progress");
		}

		return $this->generateView();
	}
	private function build_scoring_info($class_challenges, $progress_arr, $user_scores){

		$data = array();
		$pts = null;
		$cleared = null;
		$cleared_on = null;
		$attempts = null;
		if($class_challenges != false)
		foreach($class_challenges as $challenge){ /* For each class_challenge*/
			$pts = null;
			$cleared = null;
			$cleared_on = null;
			$attempts = null;
			if($user_scores != false)
			foreach($user_scores as $p){/* find its associated points */
				if($p->challenge_id == $challenge['challenge_id']){
					$pts = $p->points;
				}
			}
			if($progress_arr != false)
			foreach($progress_arr as $chal_prog){
				if($challenge['challenge_id'] == $chal_prog->challenge_id){ /* Find its progress*/
					$attempts = $chal_prog->tries;/*so we know the attempt count and if and when its cleared*/
					if( 1 === $chal_prog->status){
						$cleared = true;
						$cleared_on = $chal_prog->time;
						break;
					}
				}
			}
			$arr = array(
				'id' => $challenge['challenge_id'],
				'title' => $challenge['challenge_id'],
				'attempts' => $attempts,
				'cleared' => $cleared,
				'cleared_on' => $cleared_on,
				'points' => $pts
			);
			array_push($data, $arr);
		}
		return $data;
	}
}
