<?php
/**
 *
 * Hackademic-CMS/controller/class.LandingPageController.php
 *
 * Hackademic Landing Page Controller
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
require_once(HACKADEMIC_PATH."model/common/class.Article.php");
require_once(HACKADEMIC_PATH."controller/class.FrontendMenuController.php");

class LandingPageController extends HackademicController {

	public function go() {
		$limit = 10;
		$targetpage = SOURCE_ROOT_PATH."index.php";
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
		$total_pages = Article::getNumberOfArticles();
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

		$articles=Article::getAllArticles($start,$limit);
		if ($this->isLoggedIn()) {
			$this->addToView('username', $this->getLoggedInUser());
		}
		$this->addToView('articles', $articles);
		$this->addToView('total_pages', $total_pages);
		$this->addToView('pagination', $pagination);
		$this->setViewTemplate('landingpage.tpl');
		$this->generateView();
	}
}
