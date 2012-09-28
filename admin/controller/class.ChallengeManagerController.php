<?php
/**
 *
 * Hackademic-CMS/admin/controller/class.ChallengeManagerController.php
 *
 * Hackademic Challenge Manager Controller
 * Class for the Challenge Manager page in Backend
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
require_once(HACKADEMIC_PATH."admin/model/class.ChallengeBackend.php");
require_once(HACKADEMIC_PATH."admin/controller/class.HackademicBackendController.php");

class ChallengeManagerController extends HackademicBackendController {

	public function go() {

		if (isset($_GET["action"]) && ($_GET["action"]=="del")) {
			$id=$_GET['id'];
			$challenge=ChallengeBackend::getChallenge($id);
			$pkg_name=$challenge[0]->pkg_name;
			self::rrmdir(HACKADEMIC_PATH."challenges/".$pkg_name);
			ChallengeBackend::deleteChallenge($id);
			$this->addSuccessMessage("Challenge has been deleted succesfully");
		} else if (isset($_GET['action']) && $_GET['action'] == "add") {
			$this->addSuccessMessage("Challenge has been added succesfully. You can enable the challenge now.");
			if (isset($_SESSION['challenge_arr'])) {
				unset($_SESSION['challenge_arr']);
			}
		}
		if (isset($_GET['limit']) && $_GET['limit']!="") {
			$limit =$_GET['limit'];
		}
		else {
			$limit=25;
		}

		$total_pages = ChallengeBackend::getNumberOfChallenges();
		$targetpage = SOURCE_ROOT_PATH."admin/pages/challengemanager.php";
		$stages = 3;
		$page=0;
		if(isset($_GET['page'])) {
			$page=$_GET['page'];
		}
		if($page) {
			$start = ($page - 1) * $limit; 
		} else {
			$start = 0;
		}	
		// Initial page num setup
		if ($page == 0){$page = 1;}
		$prev = $page - 1;	
		$next = $page + 1;							
		$lastpage = ceil($total_pages/$limit);		
		$LastPagem1 = $lastpage - 1;

		$pagination = array (
				'lastpage' => $lastpage,
				'page' => $page,
				'targetpage' => $targetpage,
				'prev' => $prev,
				'next' => $next,
				'stages' => $stages,
				'last_page_m1' => $LastPagem1
				);
		if (isset($_GET['search']) && isset($_GET['category']) && $_GET['search']!='' && $_GET['category']!='') {
			$challenges = ChallengeBackend::getNchallenges($start,$limit,$_GET['search'],$_GET['category']);
		} else {
			$challenges = ChallengeBackend::getNchallenges($start, $limit);
		}
		$this->addToView('challenges', $challenges);
		$this->addToView('total_pages', $total_pages);
		$this->addToView('pagination', $pagination);
		$this->setViewTemplate('challengemanager.tpl');
		$this->generateView();
	}

	private static function rrmdir($dir) {
		foreach(glob($dir . '/*') as $file) {
				       if(is_dir($file)) {
				       self::rrmdir($file);
				       } else {
				       unlink($file);
				       }
				       }
				       rmdir($dir);
				       }
				       }
