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

class EditCodeController extends HackademicBackendController {

	public function go() {
		if (isset($_GET['id'])) {
			$id=$_GET['id'];
			$challenges=Challenge::getChallenge($id);
			$title = $challenges->title;
			$url = HACKADEMIC_PATH."challenges/".$challenges->pkg_name."/index.php";
			if(isset($_POST['submit'])) {
				$contents = $_POST['code'];
				file_put_contents($url, $contents);
				$this->addSuccessMessage("File has been updated successfully !");
			}

			if (!file_exists($url)) {
				$this->addErrorMessage("File does not exist");
				$file_contents = '';
			} else {
				$file_contents = file_get_contents($url);
			}
			$folder = $challenges->pkg_name;
		} else {
			$title = "Unknown Challenge";
			$file_contents = '';
			$folder = null;
			$this->addErrorMessage("You need to select a challenge to edit.");
		}
		$this->setViewTemplate('editcode.tpl');
		$this->addToView('file_contents', $file_contents);
		$this->addToView('title', $title);
		$this->addToView('folder', $folder);
		$this->generateView();
	}

}
