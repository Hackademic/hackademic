<?php
/**
 *
 * Class ArticleChallengeModel
 *
 * This class handles the database interactions for connecting
 * articles with challenges.
 *
 * @author: Daniel Kvist
 * @author URI: http://danielkvist.net
 * @license: GPL2
 *
 */

require_once(HACKADEMIC_PATH . "model/common/class.HackademicDB.php");

class ArticleChallengeModel {

  private static $action_type = 'article_challenge';

  /**
   * Adds to the database
   *
   * @param $aid the article id
   * @param $cid the challenge id
   */
  public static function add($aid, $cid) {
    global $db;
    $params = array(
      ':aid' => $aid,
      ':cid' => $cid
    );
    $sql = "INSERT INTO article_challenge_connect(aid, cid) VALUES (:aid, :cid)";
    $db->create($sql, $params, self::$action_type);
  }

  /**
   * Gets cid from the database from the article specified by aid.
   *
   * @param $aid article id
   * @return mixed row with cid
   */
  public static function get($aid) {
    global $db;
    $params = array(':aid' => $aid);
    $sql = "SELECT cid FROM article_challenge_connect WHERE aid = :aid";
    $row = $db->fetchArray($db->read($sql, $params, self::$action_type));
    return $row;
  }

  /**
   * Updates the cid in the database for the specific article.
   *
   * @param $aid article id
   * @param $cid challenge id
   */
  public static function update($aid, $cid) {
    global $db;
    $params = array(
      ':aid' => $aid,
      ':cid' => $cid
    );
    $sql = "UPDATE article_challenge_connect SET cid = :cid WHERE aid = :aid";
    $db->update($sql, $params, self::$action_type);
  }

  /**
   * Deletes the row with the corresponding article id.
   *
   * @param $aid article id
   */
  public static function delete($aid) {
    global $db;
    $params = array(':aid' => $aid);
    $sql = $sql = "DELETE FROM article_challenge_connect WHERE aid = :aid";
    $db->delete($sql, $params, self::$action_type);
  }

  /**
   * Checks to see if the article has a challenge connected to it.
   *
   * @param $aid article id
   * @return bool true if connected
   */
  public static function exists($aid) {
    global $db;
    $params = array(':aid' => $aid);
    $sql = "SELECT cid FROM article_challenge_connect WHERE aid = :aid";
    return $db->numRows($db->read($sql, $params, self::$action_type)) > 0;
  }

  /**
   * Creates the plugin's table if it does not already exist.
   */
  public static function createTable() {
    global $db;
    $sql = "CREATE TABLE IF NOT EXISTS `article_challenge_connect` (
      `aid` int(11) NOT NULL,
      `cid` int(11) NOT NULL,
      PRIMARY KEY (`aid`),
      FOREIGN KEY(`aid`) REFERENCES articles(`id`),
      FOREIGN KEY(`cid`) REFERENCES challenges(`id`)
    )";
    $db->query($sql);
  }

}