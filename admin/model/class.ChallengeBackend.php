<?php
/**
 * Hackademic-CMS/admin/model/class.ChallengeBackend.php
 *
 * Hackademic Backend Challenge Model
 * This class extends the functionality of Challenge class adding functions
 * specifically required for backend
 *
 * Copyright (c) 2012 OWASP
 *
 * LICENSE:
 *
 * This file is part of Hackademic CMS
 * (https://www.owasp.org/index.php/OWASP_Hackademic_Challenges_Project).
 *
 * Hackademic CMS is free software: you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 2 of the License, or (at your option) any later
 * version.
 *
 * Hackademic CMS is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
 * PARTICULAR PURPOSE.  See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * Hackademic CMS.  If not, see <http://www.gnu.org/licenses/>.
 *
 * PHP Version 5.
 *
 * @author    Pragya Gupta <pragya18nsit@gmail.com>
 * @author    Konstantinos Papapanagiotou <conpap@gmail.com>
 * @copyright 2012 OWASP
 * @license   GNU General Public License http://www.gnu.org/licenses/gpl.html
 */
require_once HACKADEMIC_PATH."/model/common/class.Challenge.php";
require_once HACKADEMIC_PATH."admin/model/class.ClassChallenges.php";

class ChallengeBackend extends Challenge
{

    /**
     * Adds a challenge to the database.
     *
     * @param Challenge $challenge Information about a challenge to be added.
     *
     * @return True if it was successfully added.
     */
    public static function addChallenge($challenge)
    {
        global $db;
        $params = array(':title' => $challenge->title,
                        ':pkg_name' => $challenge->pkg_name,
         ':description'=>$challenge->description,
         ':author' => $challenge->author,
         ':category' => $challenge->category,
         ':date_posted' => $challenge->date_posted,
         ':level' => $challenge->level,
         ':duration' => $challenge->duration);
        $sql = "INSERT INTO challenges(title, pkg_name, description, author, category, date_posted, level, duration) ";
        $sql .= "VALUES (:title, :pkg_name, :description, :author, :category, :date_posted, :level, :duration)";
        $query = $db->create($sql, $params, self::$action_type);
        if ($db->affectedRows($query)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Updates a challenge in the database.
     *
     * @param Chanllenge $challenge Information about challenge to be updated.
     *
     * @return True if it was successfully updated.
     */
    public static function updateChallenge($challenge)
    {
        global $db;
        $params = array(':id' => $challenge->id,
                        ':title' => $challenge->title,
         ':description' => $challenge->description,
         ':visibility' => $challenge->visibility,
         ':publish' => $challenge->publish,
         ':availability' => $challenge->availability,
         ':level' => $challenge->level,
         ':duration' => $challenge->duration);
        $sql = "UPDATE challenges SET title = :title, description = :description, visibility = :visibility, publish = :publish, ";
        $sql .= "availability = :availability, level = :level, duration = :duration WHERE id = :id";
        $query = $db->update($sql, $params, self::$action_type);
        if ($db->affectedRows($query)) {
            return true;
        } else {
            return false;
        }
    }

    public static function deleteChallenge($id)
    {
        global $db;
        $params = array(':id'=>$id);
        $sql = "DELETE FROM challenges WHERE id=:id";
        $query = $db->delete($sql, $params, self::$action_type);
        ClassChallenges::deleteAllMemberships($id);
        if ($db->affectedRows($query)) {
            return true;
        } else {
            return false;
        }
    }
}
