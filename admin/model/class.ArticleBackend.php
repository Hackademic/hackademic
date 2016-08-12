<?php
/**
 *
 * Hackademic-CMS/admin/mode/class.ArticleBackend.php
 *
 * Hackademic Article Backend Model
 * This class extends the functionality of Article class adding functions specifically
 * required for backend
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
require_once(HACKADEMIC_PATH."model/common/class.HackademicDB.php");
require_once(HACKADEMIC_PATH."/model/common/class.Article.php");
class ArticleBackend extends Article {

	/**
	 * Adds an article to the database.
	 * @param $article
	 * @return True if it was successfully added.
	 */
	public static function addArticle($article) {
		global $db;
		$params = array(':title' => $article->title, ':content' => $article->content, ':date_posted' => $article->date_posted,
						':created_by' => $article->created_by, ':is_published' => $article->is_published);
		$sql = "INSERT INTO articles(title, content, date_posted, created_by, is_published) ";
		$sql .= "VALUES (:title, :content, :date_posted, :created_by, :is_published)";
		$query = $db->create($sql, $params, self::$action_type);
		if ($db->affectedRows($query)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Updates an article in the database.
	 * @param $article
	 * @return True if it was successfully updated.
	 */
	public static function updateArticle($article) {
		global $db;
		$params = array(':id' => $article->id, ':title' => $article->title, ':content' => $article->content,
						':date_modified' => $article->date_modified, ':last_modified_by' => $article->last_modified_by);
		$sql = "UPDATE articles SET title = :title, content = :content, last_modified = :date_modified, ";
		$sql .= "last_modified_by = :last_modified_by WHERE id = :id";
		//yahan pr se execute ni hora h 
		$query = $db->update($sql, $params, self::$action_type);
		if ($db->affectedRows($query)) {
			return true;
		} else {
			return false;
		}
	}

	public static function deleteArticle($id){
		global $db;
		$params = array(':id' => $id);
		$sql = "DELETE FROM articles WHERE id= :id";
		$query = $db->delete($sql, $params, self::$action_type);
		if ($db->affectedRows($query)) {
			return true;
		} else {
			return false;
		}
	}

	public static function insertId() {
		global $db;
		return $db->insertId();
	}
}
