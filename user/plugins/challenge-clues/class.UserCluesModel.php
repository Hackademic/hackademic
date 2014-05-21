<?php
/**
 * Class UserCluesModel
 * This class handles the database interactions for managing the clues.
 * @author: Paul Chaignon
 * @license: GPL2
 */

require_once(HACKADEMIC_PATH . "model/common/class.HackademicDB.php");

class UserCluesModel {

  private static $action_type = 'user_clues';

  /**
   * Deletes the rows with the corresponding user id.
   * @param $uid user id
   */
  public static function deleteUser($aid) {
    global $db;
    $params = array(':uid' => $uid);
    $sql = $sql = "DELETE FROM user_clues WHERE uid = :uid";
    $db->delete($sql, $params, self::$action_type);
  }

  /**
   * Deletes the clues belonging to the corresponding challenge.
   * @param $cid challenge id
   */
  public static function deleteClue($cid) {
    global $db;
    $params = array(':cid' => $cid);
    $sql = $sql = "DELETE FROM user_clues WHERE id IN (SELECT id FROM challenges WHERE id = :cid)";
    $db->delete($sql, $params, self::$action_type);
  }

  /**
   * Creates the user-clue table for the plugin if doesn't exist yet.
   * It will contain the clues used by each user.
   */
  public static function createTable() {
    global $db;
    $sql = "CREATE TABLE IF NOT EXISTS `user_clues` (
      `user` int(11) NOT NULL,
      `clue` int(11) NOT NULL,
      PRIMARY KEY (`user`, `clue`),
      FOREIGN KEY(`user`) REFERENCES users(`id`),
      FOREIGN KEY(`clue`) REFERENCES clues(`id`)
    )";
    $db->query($sql);
  }
}
