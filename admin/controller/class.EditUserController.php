<?php
/**
 *
 * Hackademic-CMS/admin/controller/class.EditUserController.php
 *
 * Hackademic Edit User Controller
 * Class for the Edit User page in Backend
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
require_once(HACKADEMIC_PATH."model/common/class.User.php");
require_once(HACKADEMIC_PATH."model/common/class.HackademicDB.php");
require_once(HACKADEMIC_PATH."admin/controller/class.HackademicBackendController.php");
class EditUserController extends HackademicBackendController {

	public function go() {
		if (isset($_GET['id'])) {
			$id=$_GET['id'];
		}
		if(isset($_POST['submit'])) {
			if ($_POST['username']=='') {
				$this->addErrorMessage("Name of the user should not be empty");
			} elseif ($_POST['email']=='') {
				$this->addErrorMessage("Email should not be empty");
			} elseif ($_POST['full_name']=='') {
				$this->addErrorMessage("Please enter your full name");
			} elseif ($_POST['is_activated']=='') {
				$this->addErrorMessage("Is the user activated or not");
			} elseif ($_POST['type']=='') {
				$this->addErrorMessage("Please select the type of the user");
			} else {
				$this->username =$_POST['username'];
				$this->email = $_POST['email'];
				$this->password = $_POST['password'];
				$this->full_name=$_POST['full_name'];
				$this->is_activated=$_POST['is_activated'];
				$this->type=$_POST['type'];

				User::updateUser($id,$this->username,$this->full_name,$this->email,$this->password,$this->is_activated,$this->type);
				$this->addSuccessMessage("User details have been updated succesfully");
			}
		}
		$users=User::getUser($id);
		$this->setViewTemplate('edituser.tpl');
		$this->addToView('user', $users);
		$this->generateView();
		if(isset($_POST['deletesubmit'])) {
			User::deleteUser($id);
			$this->addSuccessMessage("User has been deleted succesfully");
			header('Location:'.SOURCE_ROOT_PATH."admin/pages/usermanager.php?source=del");
		}
	}
}
