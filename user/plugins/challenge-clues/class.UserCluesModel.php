<?php
/**
 * Class UserCluesModel
 * This class handles the database interactions for managing the clues.
 *
 * PHP Version 5.
 *
 * @author  Paul Chaignon
 * @license GPL2 www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 */

require_once HACKADEMIC_PATH . "model/common/class.HackademicDB.php";

class UserCluesModel
{

  private static $_action_type = 'user_clues';

  /**
   * Adds a new attribute to the clue objects to specify if the current user opened
   * them.
   *
   * @param id   $user_id The user id.
   * @param clue $clues   The clue objects.
   *
   * @return Nothing.
   */
  public static function markOpenedClues($user_id, &$clues)
  {
    global $db;
    $sql = "SELECT * FROM user_clues WHERE user = :user_id AND clue = :clue_id";
    foreach ($clues as $clue) {
      $params = array(':user_id' => $user_id, ':clue_id' => $clue->id);
      $statement_handle = $db->read($sql, $params, self::$_action_type);
      $clue->opened = $db->fetchArray($statement_handle);
    }
  }

  /**
   * Adds a new clue for an user (he's just read it).
   *
   * @param id   $user_id The user id.
   * @param clue $clue    The clue object.
   *
   * @return Nothing.
   */
  public static function addClue($user_id, $clue)
  {
    global $db;
    $params = array(':user_id' => $user_id, ':clue_id' => $clue->id);
    $sql = "INSERT INTO user_clues(user, clue) VALUES(:user_id, :clue_id)";
    $db->create($sql, $params, self::$_action_type);
  }

  /**
   * Deletes the rows with the corresponding user id.
   *
   * @param id $aid user id
   *
   * @return Nothing.
   */
  public static function deleteUser($aid)
  {
    global $db;
    $params = array(':uid' => $uid);
    $sql = "DELETE FROM user_clues WHERE uid = :uid";
    $db->delete($sql, $params, self::$_action_type);
  }

  /**
   * Deletes the clues belonging to the corresponding challenge.
   *
   * @param id $cid challenge id
   *
   * @return Nothing.
   */
  public static function deleteClue($cid)
  {
    global $db;
    $params = array(':cid' => $cid);
    $sql = "DELETE FROM user_clues WHERE id IN (SELECT id FROM challenges WHERE id = :cid)";
    $db->delete($sql, $params, self::$_action_type);
  }
}
