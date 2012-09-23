<?php
/**
 *
 * Hackademic-CMS/controller/class.LandingPageController.php
 *
 * Hackademic Landing Page Controller
 * Class for generating the home page of the website
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
require_once(HACKADEMIC_PATH."admin/controller/class.HackademicBackendController.php");

class TryChallengeController extends HackademicController {

	public function go() {
		if (isset($_GET['id'])) {
		    $id=$_GET['id'];
		    $this->addToView('id', $id);
		    $challenge=Challenge::getChallenge($id);
		    if ($this->isLoggedIn() && ($this->isAdmin() || self::IsAllowed($this->getLoggedInUser(), $challenge[0]->id))) {
			$challenge_path = SOURCE_ROOT_PATH."challenges/".$challenge[0]->pkg_name."/";
			$this->addToView('pkg_name', $challenge[0]->pkg_name);
			$solution = $challenge[0]->solution;
			if (isset($_POST) && count($_POST)!=0) {
				//echo '<div style = "color:red">CHALLENGE WAS SUBMITTED</div>';
			}
			if (!isset($_GET["path"])) {
				$url = $challenge_path."index.php";
			} else {
				$url = $challenge_path.$_GET['path'];
			}
			header("Location: ".$url);
		    } else {
			die();
		    }
		}
		$this->setViewTemplate("trychallenge.tpl");
		$this->generateView();
	}
	
	protected static function isAllowed($username, $challenge_id) {
		$user = User::findByUserName($username);
		$classes = ClassMemberships::getMembershipsOfUser($user->id);
		return ClassChallenges::isAllowed($challenge_id, $classes);
	}
}
