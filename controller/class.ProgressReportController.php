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
			$challenges_of_user = UserChallenges::getChallengesOfUser($user->id);
			$progress = ChallengeAttempts::getUserProgress($user->id);
			$data = array();
			//var_dump(UserChallenges::getChallengesOfUser($user->id));
			//echo'</p>';var_dump($progress);
			foreach ($challenges_of_user as $challenge) {
				$attempts = 0;
				$cleared = false;
				$cleared_on = null;
				foreach($progress as $chal_prog){
					if($challenge->id === $chal_prog->challenge_id){
						$attempts = $chal_prog->count;
						if( 1 === $chal_prog->status){
							$cleared = true;
							$cleared_on = $chal_prog->time;
							//unset($progress[$chal_prog]);
							break;
						}
					}
				}
				$arr = array(
					'id' => $challenge->id,
					'title' => $challenge->title,
					'attempts' => $attempts,
					'cleared' => $cleared,
					'cleared_on' => $cleared_on
				);
				//echo'</p>';var_dump($arr);
				array_push($data, $arr);

			}
			//var_dump($cleared_challenges);
			$this->addToView('data', $data);
		} else {
			$this->addErrorMessage("Please select a student to see his progress");
		}

		return $this->generateView();
	}
}
