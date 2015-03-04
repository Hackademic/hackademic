<?php
/**
 *
 * Hackademic-CMS/admin/controller/class.EditChallengeController.php
 *
 * Hackademic Edit Challenge Controller
 * Class for the Editllenge page in Backend
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
require_once(HACKADEMIC_PATH."model/common/class.Challenge.php");
require_once(HACKADEMIC_PATH."admin/model/class.ChallengeBackend.php");
require_once(HACKADEMIC_PATH."admin/controller/class.HackademicBackendController.php");
require_once(HACKADEMIC_PATH."model/common/class.Utils.php");

class EditChallengeController extends HackademicBackendController {

  private static $action_type = 'edit_challenge';

	public function go() {
		if(isset($_GET['id'])) {
			$id = $_GET['id'];
		}
		if(isset($_POST['submit'])) {
			if ($_POST['title']=='') {
				$this->addErrorMessage("Title of the challenge should not be empty");
			} elseif ($_POST['description']=='') {
				$this->addErrorMessage("Description should not be empty");
			} elseif ($_POST['visibility']=='') {
				$this->addErrorMessage("Visibility field should not be empty");
			} elseif ($_POST['level']=='') {
				$this->addErrorMessage("Level field should not be empty");
			} elseif ($_POST['duration']=='') {
				$this->addErrorMessage("Duration field should not be empty");
			} else {
				$challenge = new Challenge();
				$challenge->id = $id;
				$challenge->title = Utils::sanitizeInput($_POST['title']);
				$challenge->description = $_POST['description'];
				$challenge->visibility = Utils::sanitizeInput($_POST['visibility']);
				$challenge->publish = Utils::sanitizeInput($_POST['publish']);
				$challenge->availability = Utils::sanitizeInput($_POST['availability']);
				$challenge->level = Utils::sanitizeInput($_POST['level']);
				$challenge->duration = Utils::sanitizeInput($_POST['duration']);
				ChallengeBackend::updateChallenge($challenge);
				$this->addSuccessMessage("Challenge details have been updated succesfully");
			}
		}
		$challenges=Challenge::getChallenge($id);
		$this->setViewTemplate('editchallenge.tpl');
		$this->addToView('challenge', $challenges);
		$this->generateView(self::$action_type);
	}
}
