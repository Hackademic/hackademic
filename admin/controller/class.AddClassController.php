<?php
/**
 *
 * Hackademic-CMS/admin/controller/class.AddClassController.php
 *
 * Hackademic Add Class Controller
 * Class for the Add Class page in Backend
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
require_once(HACKADEMIC_PATH."admin/model/class.Classes.php");
require_once(HACKADEMIC_PATH."/admin/controller/class.HackademicBackendController.php");
require_once(HACKADEMIC_PATH."model/common/class.Utils.php");

class AddClassController extends HackademicBackendController {

	public function go() {
		$this->setViewTemplate('addclass.tpl');
		if(isset($_POST['submit'])) {
			if ($_POST['classname']=='') {
				$this->addErrorMessage("Name of the class should not be empty");
			} else {
				// $this->created_by= Session::getLoggedInUser();
				$classname = Utils::sanitizeInput($_POST['classname']);
				$date_created = date("Y-m-d H:i:s");
				if (Classes::doesClassExist($classname)) {
				$this->addErrorMessage(" This Classname already exists");
				}
				else{
				Classes::addClass($classname,$date_created);
				header('Location: '.SOURCE_ROOT_PATH."admin/pages/manageclass.php?source=addclass");
			    }
			}
		}
		$this->generateView();
	}
} 
