<?php
/**
 *
 * Hackademic-CMS/admin/controller/class.HackademicBackendController.php
 * 
 * Hackademic Backend Controller
 * The parent class of all Hackademic Backend controllers.
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
require_once(HACKADEMIC_PATH."admin/controller/class.MenuController.php");
require_once(HACKADEMIC_PATH."controller/class.HackademicController.php");

class HackademicBackendController extends HackademicController {

	public function __construct() {
		HackademicController::__construct();
		// Login Controller, do nothing
		if (get_class($this) == 'LoginController');
		elseif (!$this->isLoggedIn()) {
			// Else if not logged in, go to login page
			//error_log("HACKADEMIC:: admin dashboard FAILURE", 0);
			header('Location: '.SOURCE_ROOT_PATH."admin/pages/login.php");
		} elseif ($this->isLoggedIn()) {
			// Else if is logged in
		 	if (($this->isAdmin() || ($this->isTeacher()))) {
				// If is Admin or Teacher, go to Admin Dashboard
				$menu=MenuController::go();
				$this->addToView("main_menu_admin",$menu);
			} else header('Location: '.SOURCE_ROOT_PATH);
				// Else go to main site
		}
	}


	/**
	 * Function to set view template
	 * @param $tmpl str Template name
	 */
	public function setViewTemplate($tmp1) {
		$this->view_template=HACKADEMIC_PATH.'admin/view/'.$tmp1;
	}
}
