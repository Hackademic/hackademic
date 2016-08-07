<?php
/**
 *
 * Hackademic-CMS/admin/controller/class.ClassChallengesController.php
 *
 * Hackademic Class Challenges Controller
 * Class for the Class Challenges page in Backend
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
require_once(HACKADEMIC_PATH."admin/model/class.ClassChallenges.php");
require_once(HACKADEMIC_PATH."admin/model/class.Classes.php");
require_once(HACKADEMIC_PATH."admin/controller/class.HackademicBackendController.php");

class ClassChallengesController extends HackademicBackendController {

	public function go() {
		$this->setViewTemplate('classchallenges.tpl');
		$challenge_id=$_GET['id'];
		if (isset($_POST['submit'])) {
			$class_id=$_POST['class_id'];
			if(ClassChallenges::doesMembershipExist($challenge_id, $class_id))
			{
				$this->addErrorMessage("Challenge is already a member of this class");
			}
			else{
				ClassChallenges::addMembership($challenge_id,$class_id);
				$this->addSuccessMessage("Challenge has been added to the class succesfully");
			}
		}
		elseif (isset($_GET['action']) && $_GET['action']=="del") {
			$class_id=$_GET['class_id'];
			ClassChallenges::deleteMembership($challenge_id,$class_id);
			$this->addSuccessMessage("Challenge has been deleted from the class succesfully");
		}	
		$class_memberships = ClassChallenges::getMembershipsOfChallenge($challenge_id);

		$classes = Classes::getAllClasses();
		$this->addToView('classes', $classes);
		$this->addToView('class_memberships', $class_memberships);
		$this->setViewTemplate('classchallenges.tpl');
		$this->generateView();
	}
}
