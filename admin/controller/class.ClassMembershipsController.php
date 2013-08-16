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
require_once(HACKADEMIC_PATH."admin/model/class.Classes.php");
require_once(HACKADEMIC_PATH."admin/controller/class.HackademicBackendController.php");
require_once(HACKADEMIC_PATH."model/common/class.User.php");

class ClassMembershipsController extends HackademicBackendController {

	public function go() {
		$this->setViewTemplate('classmembership.tpl');
		$user_id=$_GET['id'];
		$user= User::getUser($user_id);
		if (isset($_POST['submit'])) {
			$class_id=$_POST['class_id'];
			if(ClassMemberships::doesMembershipExist($user_id, $class_id))
			{
				$this->addErrorMessage("User is already a member of this class");
			}
			else{
				ClassMemberships::addMembership($user_id,$class_id);
				$this->addSuccessMessage("User has been added to the class succesfully");
			}
		}
		elseif (isset($_GET['action']) && $_GET['action']=="del") {
			$class_id=$_GET['class_id'];
			ClassMemberships::deleteMembership($user_id,$class_id);
			$this->addSuccessMessage("User has been deleted from the class succesfully");
		}	
		$class_memberships = ClassMemberships::getMembershipsOfUser($user_id);

		$classes = Classes::getAllClasses();
		$this->addToView('classes', $classes);
		$this->addToView('class_memberships', $class_memberships);
		$this->addToView('user', $user);
		$this->setViewTemplate('classmembership.tpl');
		$this->generateView();
	}
}
