<?php
/**
 *
 * Hackademic-CMS/admin/model/class.ChallengeBackend.php
 *
 * Hackademic Backend Challenge Model
 * This class extends the functionality of Challenge class adding functions specifically
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
require_once(HACKADEMIC_PATH."/model/common/class.Challenge.php");
require_once(HACKADEMIC_PATH."admin/model/class.ClassChallenges.php");

class ChallengeBackend extends Challenge{

	public static function addchallenge($title,$pkg_name,$description,$author,$category,$date_posted,$level,$duration){
		global $db;
		$description=mysql_escape_string(trim($description));
		$title=mysql_escape_string(trim($title));
		$author=mysql_escape_string(trim($author));
		$params=array(':title'=>$title,':pkg_name'=>$pkg_name,':description'=>$description,
				':author'=>$author,':category'=>$category,':date_posted'=>$date_posted,
				':level'=>$level,':duration'=>$duration);
		$sql="INSERT INTO challenges(title,pkg_name,description,author,category,date_posted,default_points,default_duration)";
		$sql .= "VALUES (:title,:pkg_name,:description,:author,:category,:date_posted,:level,:duration)";
		$query = $db->query($sql,$params);
		if ($db->affectedRows($query)) {
			return true;
		} else {
			return false;
		}
	}

	public static function updateChallenge($id,$title,$description,$visibility,$publish, $availability,$duration,$level){
		global $db;
		$params=array(':id' => $id,':title' => $title,':description' => $description,
			      ':visibility' => $visibility,':publish' => $publish,':availability'=>$availability,
			      ':level'=>$level,':duration'=>$duration);
		$sql="UPDATE challenges SET title=:title,
					    description=:description,
					    visibility=:visibility,
					    publish=:publish,
					    availability=:availability,
					    default_points=:level,
					    default_duration=:duration";
		$sql .= " WHERE id=:id";
		$query = $db->query($sql,$params);
		if ($db->affectedRows($query)) {
			return true;
		} else {
			return false;
		}
	}
	public static function deleteChallenge($id){
		global $db;
		$params=array(':id'=>$id);
		$sql = "DELETE FROM challenges WHERE id=:id";
		$query = $db->query($sql,$params);
		ClassChallenges::deleteAllMemberships($id);
		if ($db->affectedRows($query)) {
			return true;
		} else {
			return false;
		}
	}
}
