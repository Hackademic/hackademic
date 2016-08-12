<?php
/**
*
* Hackademic-CMS/admin/controller/class.AddArticleController.php
*
* Hackademic Add Article Controller
* Class for the Add Article page in Backend
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
* warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
* details.
*
* You should have received a copy of the GNU General Public License along with Hackademic CMS. If not, see
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
require_once(HACKADEMIC_PATH."admin/model/class.ArticleBackend.php");
require_once(HACKADEMIC_PATH."/admin/controller/class.HackademicBackendController.php");
require_once(HACKADEMIC_PATH."/model/common/class.Utils.php");

class AddArticleController extends HackademicBackendController {

	public $title;
	public $publish;
	public $article;

  private static $action_type = 'add_article';

	public function go() {
		$this->saveFormFields();
		$this->setViewTemplate('editor.tpl');
		if(isset($_POST['submit'])) {
			if ($_POST['title']=='') {
				$this->addErrorMessage("Title of the article should not be empty");
			} elseif (!isset($_POST['is_published'])) {
				$this->addErrorMessage("Please tell if the article should be published");
			} elseif ($_POST['content']=='') {
				$this->addErrorMessage("Article post should not be empty");
			} else {
				$article = new Article();
				$article->created_by = Session::getLoggedInUser();
				$article->title = Utils::sanitizeInput($_POST['title']);
				$article->is_published = $_POST['is_published'];
				$article->content = $_POST['content'];//TODO somehow we must check if this is malicious
				$article->date_posted = date("Y-m-d H:i:s");
				ArticleBackend::addArticle($article);
				$this->addSuccessMessage("Article has been added succesfully");
				$id = ArticleBackend::insertId();
				header('Location: ' . SOURCE_ROOT_PATH."?url=admin/editarticle&id=$id&source=new");
				die();
			}
		}
		$this->generateView(self::$action_type);
	}

	public function saveFormFields(){
		if(isset($_POST['title'])) {
      $this->title = Utils::sanitizeInput($_POST['title']);
    }
		if(isset($_POST['is_published'])) {
      $this->publish = $_POST['is_published'];
    }
		if(isset($_POST['content'])) {
      $this->article = $_POST['content'];
    }
		$this->addToView('cached', $this);
	}
}
