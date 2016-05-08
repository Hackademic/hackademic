<?php
/**
 *
 * Hackademic-CMS/controller/class.RegisterUserController.php
 *
 * Hackademic Register  User Controller
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
require_once(HACKADEMIC_PATH."controller/class.HackademicController.php");
require_once(HACKADEMIC_PATH."model/common/class.User.php");
require_once(HACKADEMIC_PATH."model/common/class.Mailer.php");
require_once(HACKADEMIC_PATH."model/common/class.Utils.php");


class RegisterUserController extends HackademicController {

	public $username;
	public $name;
	public $email;
	public $form_fields = array('username', 'full_name', 'password', 'confirmpassword', 'email');

  private static $action_type = 'register_user';

	public function go() {
		$this->setViewTemplate('register_user.tpl');
		if (isset($_POST['submit'])) {
			$this->setEmptyIfNotExist();
			$this->saveFormFields();
			if ($_POST['username']=='') {
				$this->addErrorMessage("Username should not be empty");
			} elseif (strpos($_POST['username'], "\0") !== FALSE) {
				$this->addErrorMessage("Null Byte characters are not valid");	
			} elseif ($_POST['full_name']=='') {
				$this->addErrorMessage("Full name should not be empty");
			} elseif ($_POST['password']=='') {
				$this->addErrorMessage("Password should not be empty");
			} elseif ($_POST['confirmpassword']=='') {
				$this->addErrorMessage("Please confirm password");
			} elseif ($_POST['email']=='') {
				$this->addErrorMessage("please enter ur email id");	    
			} else {
				$username = Utils::sanitizeInput($_POST['username']);
				$password = $_POST['password'];
				$confirmpassword=$_POST['confirmpassword'];
				$full_name = Utils::sanitizeInput($_POST['full_name']);
				$email= Utils::sanitizeInput($_POST['email']);  //esapi email encode
				//$is_activated = $_POST['is_activated'];
				if (User::doesUserExist($username)) {
					$this->addErrorMessage("Username already exists");
				}
				elseif(User::doesEmailExist($email)) {
					$this->addErrorMessage("Email already exists");
				}
				elseif(!($password==$confirmpassword)) {
					$this->addErrorMessage("The two passwords dont match!");
				}
				elseif(!Utils::validateEmail($email)) {
					$this->addErrorMessage("Please enter a valid email id");
				} else {
					//$this->destroyFormFields();
					$this->setViewTemplate('mainlogin.tpl');
					$subject="Hackademic new account";
					$message="Hackademic account created succesfully";
					//Mailer::mail($email,$subject,$message);
					$joined=date("Y-m-d H-i-s");
					$result = User::addUser($username,$full_name,$email,$password,$joined);
					$usr = User::findByUserName($username);
					$res2 = ClassMemberships::addMembership($usr->id, GLOBAL_CLASS_ID);
					$this->addSuccessMessage("You have been registered succesfully");
				}
			}
		}else{
			$this->addToView('cached', $this);
		}
		
		return $this->generateView(self::$action_type);
	}

	public function saveFormFields() {
		$this->username = Utils::sanitizeInput($_POST['username']);
		$this->name = Utils::sanitizeInput($_POST['full_name']);
		$this->email = $_POST['email'];
		$this->addToView('cached', $this);
	}

	public function setEmptyIfNotExist(){
		foreach ($this->form_fields as $field) {
			if (!isset($_POST[$yfield)){
				$_POST[$field] = "";
			}
		}
	}

}
