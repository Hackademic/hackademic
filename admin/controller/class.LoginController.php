<?php
/**
 *
 * Hackademic-CMS/admin/controller/class.LoginController.php
 *
 * Hackademic Backend Login Controller
 * Controller for logging into backend.
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
require_once(HACKADEMIC_PATH."admin/controller/class.DashboardController.php");
require_once(HACKADEMIC_PATH."admin/controller/class.HackademicBackendController.php");
require_once(HACKADEMIC_PATH."model/common/class.User.php");

class LoginController extends HackademicBackendController {

	public function go() {
		$this->setViewTemplate('admin_login.tpl');
		$this->addPageTitle('Log in');

		if ($this->isLoggedIn()) {
			header('Location: '.SOURCE_ROOT_PATH."admin/pages/dashboard.php");
		} else  {
			if (isset($_POST['submit']) && $_POST['submit']=='Login'
					&& isset($_POST['username']) && isset($_POST['pwd']) ) {
				if ($_POST['username']=='' || $_POST['pwd']=='') {
					if ($_POST['username']=='') {
						$this->addErrorMessage("Username must not be empty");
						return $this->generateView();
					} else {
						$this->addErrorMessage("Password must not be empty");
						return $this->generateView();
					}
				} else {
					$session = new Session();
					$username = $_POST['username'];
					$this->addToView('username', $username);
					$user=User::findByUsername($username);
					if (!$user) {
						$this->addErrorMessage("Incorrect username or password");
						return $this->generateView();
					} elseif (!$session->pwdCheck($_POST['pwd'], $user->password)) {
						$this->addErrorMessage("Incorrect username or password");
						return $this->generateView();
					} elseif(!$user->type) {
						$this->addErrorMessage("You are not an administrator");
						return $this->generateView();
					} else {
						// this sets variables in the session
						$session->completeLogin($user);
						header('Location: '.SOURCE_ROOT_PATH."admin/pages/login.php");
					}
				}
			} else {
				$this->addPageTitle('Log in');
				return $this->generateView();
			}
		}
	}
}
