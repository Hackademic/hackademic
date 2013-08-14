<?php
/**
 *
 * Hackademic-CMS/admin/controller/class.ClassMembershipsController.php
 *
 * Hackademic Class Memberships Controller
 * Class for the Class Memberships page in Backend
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
require_once(HACKADEMIC_PATH."admin/model/class.ClassMemberships.php");
require_once(HACKADEMIC_PATH."admin/model/class.ClassChallenges.php");
require_once(HACKADEMIC_PATH."admin/model/class.Classes.php");
require_once(HACKADEMIC_PATH."admin/controller/class.HackademicBackendController.php");
require_once(HACKADEMIC_PATH."model/common/class.Challenge.php");
require_once(HACKADEMIC_PATH."model/common/class.Utils.php");
require_once(HACKADEMIC_PATH."model/common/class.ScoringRule.php");
class ShowClassController extends HackademicBackendController {

	public function go() {
		$this->setViewTemplate('showclass.tpl');

		if (!isset($_GET['id'])) {
			header('Location: '.SOURCE_ROOT_PATH."admin/pages/manageclass.php");
		}
		$class_id=$_GET['id'];

		$class = Classes::getClass($class_id);
		$change = false;

		if(isset($_POST['submit'])) {
			if(isset($_POST['updateclassname'])) {
				if ($_POST['updateclassname']=='') {
					header('Location: '.SOURCE_ROOT_PATH."admin/pages/showclass.php?id=$class_id&action=editerror");
				}
				else {
					if ($_POST['challenges'] !='default') {
						ClassChallenges::addMembership($_POST['challenges'],$_GET['id']);
						$this->addSuccessMessage("Challenge has been added to the class succesfully");
					}
					if($_POST['updateclassname'] != $class->name){
						$change = true;
						$this->name = Utils::sanitizeInput($_POST['updateclassname']);
						Classes::updateClassName($class_id, $this->name);
						header('Location: '.SOURCE_ROOT_PATH."admin/pages/showclass.php?id=$class_id&action=editsuccess&message=cname");
					}
				}
			}
		}
		if (isset($_GET['action']) && $_GET['action'] == "editerror") {
			$this->addErrorMessage("Class name should not be empty");
		}
		if (isset($_GET['action']) && $_GET['action'] == "editsuccess") {
			$this->addSuccessMessage("Class name updated successfully");
		}
		if (isset($_GET['action']) && $_GET['action'] == "del") {
			if (isset($_GET['uid'])) {
				ClassMemberships::deleteMembership($_GET['uid'],$class_id);
				$this->addSuccessMessage("User has been deleted from the class succesfully");
			} else if (isset($_GET['cid'])) {
				ClassChallenges::deleteMembership($_GET['cid'],$class_id);
				$this->addSuccessMessage("Challenge has been deleted from the class succesfully");
			}
		}


		$user_members = ClassMemberships::getAllMemberships($class_id);
		$challenges_assigned = ClassChallenges::getAllMemberships($class_id);
		$rules_arr = array();
		foreach($challenges_assigned as $challenge){
			$rule = ScoringRule::get_scoring_rule_by_challenge_class_id($challenge['challenge_id'], $class_id);
			if($rule == NO_RESULTS )
				$rule = ScoringRule::get_scoring_rule(DEFAULT_RULES_ID);
			$rules_arr[$challenge['challenge_id']] = ScoringRule::getRuleSummary($rule);
		}
		if($change)
			$class = Classes::getClass($class_id);
/*
		var_dump($challenges_not_assigned);
		var_dump($challenges_assigned);
*/
		$challenges_not_assigned = ClassChallenges::getNotMemberships($class_id);
		$this->addToView('class', $class);
		$this->addToView('challenges_not_assigned',$challenges_not_assigned);
		$this->addToView('users', $user_members);
		$this->addToView('challenges', $challenges_assigned);
		$this->addToView('rules',$rules_arr);
		return $this->generateView();
	}
}
