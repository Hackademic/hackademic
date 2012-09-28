<?php
/**
 *
 * Hackademic-CMS/controller/class.ResetPasswordController.php
 *
 * Hackademic Reset Password Controller
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


class ResetPasswordController extends HackademicController {


	public function go() {
		$this->setViewTemplate('resetpw.tpl');
		if (isset($_GET['username'])) {
			$username=$_GET['username'];
		}
		if (isset($_GET['token'])) {
			$token=$_GET['token'];
		}
		if(!(User::validateToken($username,$token))){
			$this->addErrorMessage("The token is invalid");
		}
		else{
			if (isset($_POST['submit'])) {
				if ($_POST['newpassword']=='') {
					$this->addErrorMessage("Password should not be empty");
				} elseif ($_POST['confirmnewpassword']=='') {
					$this->addErrorMessage("Confirm password field should not be empty");
				}  else {
					$password = $_POST['newpassword'];
					$confirmpassword=$_POST['confirmnewpassword'];
					if(!($password==$confirmpassword)) {
						$this->addErrorMessage("The two passwords dont match!");
					}
					else{
						if(!(User::updatePassword($password,$username)))
							$this->addErrorMessage("An error occured while updating the password");
						else{
							$this->addSuccessMessage("Password has been updated successfully!You can now login with your new password");
						}
					}
				}
			}
		}
		return $this->generateView();
	}
}
