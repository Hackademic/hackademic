<?php
/**
 * Hackademic-CMS/model/common/class.ChallengeScoring.php
 *
 * Hackademic UserScore Class
 * Class for Hackademic's ScoringRule Object
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
 * @author    Spyros Gasteratos
 * @author    Konstantinos Papapanagiotou <conpap@gmail.com>
 * @copyright 2013 OWASP
 * @license   GNU General Public License http://www.gnu.org/licenses/gpl.html
 */

class UserScore
{

    private static $_action_type = 'user_score';

    public $id = null;
    public $challenge_id = null;
    public $class_id = null;
    public $user_id = null;
    public $points = null;
    public $penalties_bonuses = "";

    /**
     * Adds a score entry for a user solving the specific challenge
     * this function is called each time the user tries the challenge
     * and it's updated with the bonuses or penalties the user has.
     *
     * @param Score $score The score object to add.
     *
     * @return Return true on success and false otherwise.
     */
    public static function addUserScore($score)
    {
        global $db;
        $params = array(':user_id' => $score->user_id, ':challenge_id' => $score->challenge_id,
         ':class_id' => $score->class_id, ':points' => $score->points,
         ':penalties_bonuses' => $score->penalties_bonuses);
        $sql = "INSERT INTO user_score(user_id, challenge_id, class_id, points, penalties_bonuses) ";
        $sql .= "VALUES (:user_id, :challenge_id, :class_id, :points, :penalties_bonuses)";
        $statement_handle = $db->create($sql, $params, self::$_action_type);
        if ($db->affectedRows($statement_handle)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Deletes an user's score.
     *
     * @param ID $id The id of the score.
     *
     * @return True on success and false otherwise.
     */
    public static function deleteUserScore($id)
    {
        global $db;
        $params = array(':id' => $id);
        $sql = "DELETE FROM user_score WHERE id = :id";
        $statement_handle = $db->delete($sql, $params, self::$_action_type);
        ClassChallenges::deleteAllMemberships($id);
        if ($db->affectedRows($statement_handle)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Update a score entry in the database.
     *
     * @param Score $score The score to update.
     *
     * @return True on success and false otherwise.
     */
    public static function updateUserScore($score)
    {
        global $db;
        if (self::getScoresForUserClassChallenge($score->user_id, $score->class_id, $score->challenge_id) === false) {
            return self::addUserScore($score);
        }
        $params = array(':user_id' => $score->user_id, ':challenge_id' => $score->challenge_id,
         ':class_id' => $score->class_id, ':points' => $score->points,
         ':penalties_bonuses' => $score->penalties_bonuses,':id' => $score->id);
        $sql = "UPDATE user_score SET user_id = :user_id, challenge_id = :challenge_id, class_id = :class_id, ";
        $sql .= "points = :points,	penalties_bonuses = :penalties_bonuses WHERE id = :id";
        $statement_handle = $db->update($sql, $params, self::$_action_type);
        if ($db->affectedRows($statement_handle)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * To get user score.
     *
     * @param ID $id User score ID
     *
     * @return the score with id $id
     */
    public static function getUserScore($id)
    {
        global $db;
        $params = array(':id' => $id);
        $sql = "SELECT * FROM user_score WHERE id = :id LIMIT 1";
        $result_array = self::findBySQL($sql, $params);
        return !empty($result_array)? array_shift($result_array) : false;
    }

    /**
     * To get scores for user
     *
     * @param ID $user_id ID of the user
     *
     * @return the score information for users with id = user_id
     *         or false if the id does not exist
     */
    public static function getScoresForUser($user_id)
    {
        global $db;
        $params = array(':user_id' => $user_id);
        $sql = "SELECT * FROM user_score WHERE user_id = :user_id LIMIT 1";
        $result_array = self::findBySQL($sql, $params);
        return !empty($result_array)? $result_array : false;
    }

    /**
     * To get scored for challenge.
     *
     * @param ID $challenge_id ID of the challenge.
     *
     * @return he scores for the challenge_id or false if the id does not exist
     */
    public static function getScoresForChallenge($challenge_id)
    {
        global $db;
        $params = array(':challenge_id' => $challenge_id);
        $sql = "SELECT * FROM user_score WHERE challenge_id = :challenge_id LIMIT 1";
        $result_array = self::findBySQL($sql, $params);
        return !empty($result_array)? array_shift($result_array) : false;
    }

    /**
     * To Get Score for class.
     *
     * @param ID $class_id ID of the class
     *
     * @return The class scores
     */
    public static function getScoresForClass($class_id)
    {
        global $db;
        $params = array(':class_id' => $class_id);
        $sql = "SELECT * FROM user_score WHERE class_id = :class_id LIMIT 1";
        $result_array = self::findBySQL($sql, $params);
        return !empty($result_array)? array_shift($result_array) : false;
    }

    /**
     * To get scores for user class.
     *
     * @param ID $user_id  ID of the user.
     * @param ID $class_id ID of the class.
     *
     * @return The score information for the specific user in specific class for all
     *         challenges
     */
    public static function getScoresForUserClass($user_id, $class_id)
    {
        global $db;
        $params = array(':user_id' => $user_id, ':class_id' => $class_id);
        $sql = "SELECT * FROM user_score WHERE user_id = :user_id AND class_id= :class_id";
        $result_array = self::findBySQL($sql, $params);
        return !empty($result_array)? $result_array : false;
    }

    /**
     * To get the score for a user class challenge.
     *
     * @param ID $user_id      ID of the user.
     * @param ID $class_id     ID of the class.
     * @param ID $challenge_id ID of the challenge
     *
     * @return The score information for the specific user in
     *         the specific class for the specific challenge
     */
    public static function getScoresForUserClassChallenge($user_id, $class_id, $challenge_id)
    {
        global $db;
        $params = array (':user_id' => $user_id, ':class_id' => $class_id, ':challenge_id' => $challenge_id);
        $sql = "SELECT * FROM user_score WHERE user_id = :user_id AND class_id = :class_id AND challenge_id = :challenge_id";
        $result_array = self::findBySQL($sql, $params);
        return !empty($result_array)? array_shift($result_array) : false;
    }

    public static function instantiate($record)
    {
        $object=new self;
        foreach ($record as $attribute=>$value) {
            if ($object->_hasAttribute($attribute)) {
                $object->$attribute=$value;
            }
        }
        return $object;
    }

    private function _hasAttribute($attribute)
    {
        $object_vars=get_object_vars($this);
        return array_key_exists($attribute, $object_vars);
    }

    /**
     * Retrieves scores from the database.
  *
     * @param SQL   $sql    The SQL query.
     * @param Param $params The parameters for the query.
     *
     * @return An array of UserScore objects.
     */
    private static function findBySQL($sql, $params = null)
    {
        global $db;
        $statement_handle = $db->read($sql, $params, self::$_action_type);
        $object_array = array();
        while ($row = $db->fetchArray($statement_handle)) {
            $object_array[] = self::instantiate($row);
        }
        return $object_array;
    }

}
    ?>
