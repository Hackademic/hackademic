<?php
/**
 *
 * Hackademic-CMS/model/common/class.Article.php
 *
 * Hackademic Article Class
 * Class for Hackademic's Article Object
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

class Article {
	public $id;
	public $title;
	public $content;
	public $date_posted;
	public $created_by;
	public $last_modified;
	public $last_modified_by;
	public $ordering;
	public $is_published;

	public static function getArticle($id) {
		global $db;
		$sql = "SELECT * FROM articles WHERE id = :id LIMIT 1";
		$params = array(
				':id' => $id
			       );
		$result_array=self::findBySQL($sql, $params);
		return !empty($result_array)?array_shift($result_array):false;
	}

	public static function getAllArticles($start, $limit) {
		global $db;
		$sql = "SELECT * FROM articles WHERE is_published = 1 ORDER BY date_posted DESC LIMIT :start, :limit ";
		$params = array(
				':start' => $start,
				':limit' => $limit
			       );
		$result_array=self::findBySQL($sql,$params);
		// return !empty($result_array)?array_shift($result_array):false;
		return $result_array;
	}

	private static function findBySQL($sql, $params=NULL) {
		global $db;
		$result_set=$db->query($sql,$params);
		$object_array=array();
		while($row=$db->fetchArray($result_set)) {
			$object_array[]=self::instantiate($row);
		}
		return $object_array;
	}

	public static function getNarticles ($start, $limit, $search=null, $category=null) {
		global $db;
		$params = array(
				':start' => $start,
				':limit' => $limit
			       );
		if ($search != null && $category != null) {
			$params[':search_string'] = '%'.$search.'%';
			switch($category){
				case "title":
					$sql = "SELECT * FROM articles WHERE title LIKE :search_string LIMIT :start, :limit";
					break;
				case "created_by":
					$sql = "SELECT * FROM articles WHERE created_by LIKE :search_string LIMIT :start, :limit";
					break;
				case "last_modified_by":
					$sql = "SELECT * FROM articles WHERE last_modified_by LIKE :search_string LIMIT :start, :limit";
					break;
			}
		} else {
			$sql= "SELECT * FROM articles ORDER BY id LIMIT :start, :limit";
		}
		$result_array=self::findBySQL($sql, $params);
		return $result_array;
	}

	public static function getNumberOfArticles($search=null, $category=null) {
		global $db;
		if ($search != null && $category != null) {
			$params[':search_string'] = '%'.$search.'%';
			switch($category){
				case "title":
					$sql = "SELECT COUNT(*) as num FROM articles WHERE title LIKE '%:search_string%'";
					break;
				case "created_by":
					$sql = "SELECT COUNT(*) as num FROM articles WHERE created_by LIKE '%:search_string%'";
					break;
				case "last_modified_by":
					$sql = "SELECT COUNT(*) as num FROM articles WHERE last_modified_by LIKE '%:search_string%'";
					break;
			}
			$query = $db->query($sql,$params);
		}
		else {
			$sql = "SELECT COUNT(*) as num FROM articles";
			$query = $db->query($sql);
		}
		$result = $db->fetchArray($query);
		return $result['num'];
	}

	public static function instantiate($record) {
		$object=new self;
		foreach($record as $attribute=>$value) {
			if($object->hasAttribute($attribute)) {
				$object->$attribute=$value;
			}
		}
		return $object;
	}

	private function hasAttribute($attribute) {
		$object_vars=get_object_vars($this);
		return array_key_exists($attribute,$object_vars);
	}
}
