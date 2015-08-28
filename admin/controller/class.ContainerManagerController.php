<?php
/**
*
* Hackademic-CMS/admin/controller/class.ContainerManagerController.php
*
* Hackademic Container Mabager Controller
* Class for Managing the containers
*
* Copyright (c) 2015 OWASP
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
* warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
* details.
*
* You should have received a copy of the GNU General Public License along with Hackademic CMS. If not, see
* <http://www.gnu.org/licenses/>.
*
*
* @author Anirudh Anand <anirudh[at]init-labs[dot]org>
* @license http://www.gnu.org/licenses/gpl.html
* @copyright 2015 OWASP
*
*/
require_once(HACKADEMIC_PATH."/admin/controller/class.HackademicBackendController.php");

class ContainerManagerController extends HackademicBackendController {

	private static $action_type = 'manage_containers';

	public function go() {
		/*
		 * Logic goes here
		 * you will need to register variables to the view with
		 * $this->addToView('name of the expected var', $var);
		 * you print error messages like this
		 * $this->addErrorMessage("your err msg");
		 * and success msg
		 * $this->addSuccessMessage("your msg");
		 *
		 * */
		$this->setViewTemplate('containermanager.tpl');

		$containers = exec('python '.HACKADEMIC_PATH.'/ContainerManager/communicator.py'.' list_containers');
		$containers = json_decode($containers, true);

		if(isset($_GET['id'])) {
			exec('python '.HACKADEMIC_PATH.'/ContainerManager/communicator.py'.' kill_container '.$_GET['id']);
			$this->addSuccessMessage("Container Killed Successfully");
		}

		$this->addToView('containers', $containers);
		$this->generateView(self::$action_type);
	}
}
