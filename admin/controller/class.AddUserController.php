<?php
/**
 *
 * Hackademic-CMS/admin/controller/class.AddUserController.php
 *
 * Hackademic Add User Controller
 * Class for the Add User page in Backend
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
require_once(HACKADEMIC_PATH."admin/controller/class.HackademicBackendController.php");
require_once(HACKADEMIC_PATH."model/common/class.User.php");
require_once(HACKADEMIC_PATH."model/common/class.Mailer.php");
require_once(HACKADEMIC_PATH."model/common/class.Utils.php");

class AddUserController extends HackademicBackendController {
	public $username;
	public $full_name;
	public $activated;
	public $type;
	public $email;

	public function go() {
		$this->saveFormFields();
		$this->setViewTemplate('adduser.tpl');
		if (isset($_POST['submit'])) {
			if ($_POST['username']=='') {
				$this->addErrorMessage("Username should not be empty");
			} elseif ($_POST['full_name']=='') {
				$this->addErrorMessage("Full name should not be empty");
			} elseif ($_POST['password']=='') {
				$this->addErrorMessage("Password should not be empty");
			} elseif ($_POST['confirmpassword']=='') {
				$this->addErrorMessage("Please confirm password");
			} elseif (!isset($_POST['activated'])) {
				$this->addErrorMessage("Is the user activated?");
			} elseif (!isset($_POST['type'])) {
				$this->addErrorMessage("Select the type of user");
			} elseif ($_POST['email']=='') {
				$this->addErrorMessage("please enter ur email id");
			} else {
				$username = $_POST['username'];
				$password = $_POST['password'];
				$confirmpassword=$_POST['confirmpassword'];
				$full_name = $_POST['full_name'];
				$email=$_POST['email'];
				$activated = $_POST['activated'];
				$type = $_POST['type'];
				if (User::doesUserExist($username)) {
					$this->addErrorMessage("Username already exists");
				}
				elseif(!($password==$confirmpassword)) {
					$this->addErrorMessage("The two passwords dont match!");
				}
				elseif(!Utils::validateEmail($email)) {
					$this->addErrorMessage("Please enter a valid email id");
				} else {
					$subject="Hackademic new account";
					$message="Hackademic account created succesfully";
					//Mailer::mail($email,$subject,$message);
					$joined=date("Y-m-d H-i-s");
					$result = User::addUser($username,$full_name,$email,$password,$joined,$activated,$type);
					$usr = User::findByUserName($username);
					$res2 = ClassMemberships::addMembership($usr->id, GLOBAL_CLASS_ID);
					$this->addSuccessMessage("User has been added succesfully");
					header('Location:'.SOURCE_ROOT_PATH."admin/pages/usermanager.php?source=add");
				}
			}
		}
		return $this->generateView();
	}
	public function saveFormFields(){
		if(isset($_POST['username']))
			$this->username =Utils::sanitizeInput($_POST['username']);
		if(isset($_POST['full_name']))
			$this->full_name=Utils::sanitizeInput($_POST['full_name']);
		if(isset($_POST['email']))
			$this->email = Utils::sanitizeInput($_POST['email']);
		if(isset($_POST['activated']))
			$this->activated = Utils::sanitizeInput($_POST['activated']);
		if(isset($_POST['type']))
			$this->type = Utils::sanitizeInput($_POST['type']);

		//var_dump($_POST['activated']);
		$this->addToView('cached', $this);
	}
}
