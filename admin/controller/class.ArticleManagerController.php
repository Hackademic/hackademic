<?php
/**
 *
 * Hackademic-CMS/admin/controller/class.ArticleManagerController.php
 *
 * Hackademic Article Manager Controller
 * Class for the Article Manager page in Backend
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
require_once(HACKADEMIC_PATH."admin/model/class.ArticleBackend.php");
require_once(HACKADEMIC_PATH."admin/controller/class.HackademicBackendController.php");

class ArticleManagerController extends HackademicBackendController {

	public function go() {
		if (isset($_GET['source']) && $_GET['source']=="del") {
			$this->addSuccessMessage("Article has been deleted succesfully");
		}

		if (isset($_GET['search']) && isset($_GET['category']) && $_GET['search']!='' && $_GET['category']!='') {
			$total_pages = ArticleBackend::getNumberofArticles($_GET['search'], $_GET['category']);
		} else {
			$total_pages = ArticleBackend::getNumberOfArticles();
		}
		$targetpage = SOURCE_ROOT_PATH."admin/pages/articlemanager.php";
		$stages = 5;
		$page=0;

		if(isset($_GET['page'])) {
			$page=$_GET['page'];
		}
		if (isset($_GET['limit']) && $_GET['limit']!="") {
			$limit =$_GET['limit'];
		}
		else {
			$limit=25;
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
			$articles = ArticleBackend::getNArticles($start,$limit,$_GET['search'],$_GET['category']);
		} else {
			$articles = ArticleBackend::getNarticles($start,$limit);
		}
		$this->addToView('articles', $articles);
		$this->addToView('total_pages', $total_pages);
		$this->addToView('pagination', $pagination);
		$this->setViewTemplate('articlemanager.tpl');
		$this->generateView();
	}
}
