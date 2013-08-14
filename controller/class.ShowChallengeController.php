<?php
/**
 *
 * Hackademic-CMS/controller/class.ShowChallengeController.php
 *
 * Hackademic Show Challenge Controller
 * Class for the Show Challenge page in Frontend
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
require_once(HACKADEMIC_PATH."admin/model/class.ClassMemberships.php");
require_once(HACKADEMIC_PATH."admin/model/class.ClassChallenges.php");
require_once(HACKADEMIC_PATH."controller/class.HackademicController.php");

class ShowChallengeController extends HackademicController {

	public function go() {
		if (isset($_GET['id'])) {
			if (isset($_GET['class_id']))
				$class_id = $_GET['class_id'];
		    $id=$_GET['id'];
		    $challenge=Challenge::getChallenge($id);
		    $this->setViewTemplate('showChallenge.tpl');
		    $this->addToView('challenge', $challenge);
		    if (!$this->isLoggedIn()) {
			    $this->addErrorMessage("You must login to be able to take the challenge");
		    } else if ($this->isAdmin() || self::IsAllowed($this->getLoggedInUser(), $challenge->id)) {
			    $this->addToView('is_allowed', true);
					$this->addToView('username', $this->getLoggedInUser());
					$this->addToView('class_id', $class_id);
		    } else {
			    $this->addErrorMessage('You cannot take the challenge as you are not a member
					    of any class to which this challenge is assigned and this challenge
					    is not publicly available for solving .');
		    }
		    //error_log("HACKADEMIC:Show Challenge controller: path".$_SESSION['hackademic_path'], 0);
		    $this->generateView();
		}
	}

	protected static function isAllowed($username, $challenge_id) {
		$user = User::findByUserName($username);
		$dbg_array = ClassChallenges::getChallengesOfUser($user->id);
		foreach($dbg_array as $element){
			if($element->id === $challenge_id)
				return true;
		}
		return false;
	}
}
