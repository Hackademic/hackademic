<?php
/**
 *
 * Hackademic-CMS/controller/class.MainLoginController.php
 *
 * Hackademic Main Login Controller
 * Class for logging into the backend
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
require_once(HACKADEMIC_PATH."model/common/class.Session.php");
require_once(HACKADEMIC_PATH."controller/class.LandingPageController.php");
require_once(HACKADEMIC_PATH."controller/class.HackademicController.php");
require_once(HACKADEMIC_PATH."model/common/class.User.php");

class MainLoginController extends HackademicController {

	public function go() {
		$this->setViewTemplate('mainlogin.tpl');
		if(isset($_GET["msg"])){
			if($_GET["msg"]=="username"){
				$this->addErrorMessage("The username or password you entered is incorrect");
			} elseif($_GET["msg"]=="password"){
				$this->addErrorMessage("The username or password you entered is incorrect");
			} elseif($_GET["msg"]=="challenge"){
				$this->addErrorMessage("You must be logged in to try a challenge");
			} elseif($_GET["msg"]=="activate"){
				$this->addErrorMessage("Your account is not activated, please contact the admin to activate your account");
			}
		}
		$this->addPageTitle('Log in');
		return $this->generateView();
	}
}
