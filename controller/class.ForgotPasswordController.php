<?php
/**
 *
 * Hackademic-CMS/controller/class.ForgotPasswordController.php
 *
 * Hackademic Forgot Password Controller
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


class ForgotPasswordController extends HackademicController {


	public function go() {
		$this->setViewTemplate('forgotpw.tpl');
		if (isset($_POST['submit'])) {
			if ($_POST['username']=='') {
				$this->addErrorMessage("Username should not be empty");
			} else {
				$username = $_POST['username'];
				//$is_activated = $_POST['is_activated'];
				if (!(User::doesUserExist($username)) || !User::isUserActivated($username)) {
					$this->addErrorMessage("Username does not exist");
				}
				else{
					global $ESAPI_utils;
					$token=$ESAPI_utils->getHttpUtilities()->getCSRFToken();
					$subject="Hackademic new password link activation";
					$message="Please click on the following link below to reset your password";
					$message = SOURCE_ROOT_PATH."pages/resetpassword.php?username=$username&token=$token";
					error_log($message);
					//Mailer::mail($email,$subject,$message);
					$result = User::addToken($username,$token);
					$this->addSuccessMessage("A mail has been send to your email  click on the link in the email to reset the password to your account");
					//header("Location: resetpassword.php?username=$username&token=$token");
				}
			}
		}
		return $this->generateView();
	}
}
