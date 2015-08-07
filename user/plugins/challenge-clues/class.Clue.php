<?php
/**
 * Class Clue
 * This class handles the database interactions for managing the clues.
 *
 * PHP Version 5.
 *
 * @author Paul Chaignon
 * @license GPL2 www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 */

require_once HACKADEMIC_PATH . 'model/common/class.HackademicDB.php';

class Clue
{
  public $id;
  public $clue_text;
  public $penalty;
  public $enabled;
  public $challenge;

  private static $_action_type = 'clue';

  /**
   * Gets clues from the database from the challenge specified challenge_id.
   * @param id $challenge_id The challenge id.
   * @return The clue objects.
   */
  public static function getClues($challenge_id)
  {
    global $db;
    $params = array(':challenge_id' => $challenge_id);
    $sql = "SELECT id, clue_text, penalty, enabled FROM clues WHERE challenge = :challenge_id";
    $clues = array();
    $statement_handle = $db->read($sql, $params, self::$_action_type);
    while ($row = $db->fetchArray($statement_handle)) {
      $clue = new Clue();
      $clue->challenge = $challenge_id;
      $clue->id = $row['id'];
      $clue->clue_text = $row['clue_text'];
      $clue->penalty = $row['penalty'];
      $clue->enabled = $row['enabled'];
      $clues[] = $clue;
    }
    return $clues;
  }

  /**
   * Gets clues from the database from the challenge specified challenge_id.
   *
   * @param id $clue_id The clue id.
   *
   * @return The clue objects.
   */
  public static function getEnabledClue($clue_id)
  {
    global $db;
    $params = array(':clue_id' => $clue_id);
    $sql = "SELECT * FROM clues WHERE enabled AND id = :clue_id";
    $clue = null;
    $statement_handle = $db->read($sql, $params, self::$_action_type);
    if ($row = $db->fetchArray($statement_handle)) {
      $clue = new Clue();
      $clue->challenge = $row['challenge'];
      $clue->id = $clue_id;
      $clue->clue_text = $row['clue_text'];
      $clue->penalty = $row['penalty'];
      $clue->enabled = $row['enabled'];
    }
    return $clue;
  }

  /**
   * Gets clues from the database from the challenge specified challenge_id.
   *
   * @param id $challenge_id The challenge id.
   *
   * @return The clue objects.
   */
  public static function getEnabledClues($challenge_id)
  {
    global $db;
    $params = array(':challenge_id' => $challenge_id);
    $sql = "SELECT id, clue_text, penalty, enabled FROM clues WHERE enabled AND challenge = :challenge_id";
    $clues = array();
    $statement_handle = $db->read($sql, $params, self::$_action_type);
    while ($row = $db->fetchArray($statement_handle)) {
      $clue = new Clue();
      $clue->challenge = $challenge_id;
      $clue->id = $row['id'];
      $clue->clue_text = $row['clue_text'];
      $clue->penalty = $row['penalty'];
      $clue->enabled = $row['enabled'];
      $clues[] = $clue;
    }
    return $clues;
  }

  /**
   * Gets clues' id from the database from the challenge specified challenge_id.
   *
   * @param id $challenge_id The challenge id.
   *
   * @return The id of the clues.
   */
  public static function getCluesId($challenge_id)
  {
    global $db;
    $params = array(':challenge_id' => $challenge_id);
    $sql = "SELECT id FROM clues WHERE challenge = :challenge_id";
    $clues = array();
    $statement_handle = $db->read($sql, $params, self::$_action_type);
    while ($row = $db->fetchArray($statement_handle)) {
      $clues[] = $row['id'];
    }
    return $clues;
  }

  /**
   * Adds a clue to the database.
   *
   * @param array $clue The clue object.
   *
   * @return Nothing.
   */
  public static function addClue($clue)
  {
    global $db;
    $params = array(
      ':challenge' => $clue->challenge,
      ':clue_text' => $clue->clue_text,
      ':penalty' => $clue->penalty,
      ':enabled' => $clue->enabled
    );
    $sql = "INSERT INTO clues(challenge, clue_text, penalty, enabled) VALUES (:challenge, :clue_text, :penalty, :enabled)";
    $db->create($sql, $params, self::$_action_type);
  }

  /**
   * Updates the clue in the database.
   *
   * @param array $clue The clue object.
   *
   * @return Nothing.
   */
  public static function updateClue($clue)
  {
    global $db;
    $params = array(
      ':id' => $clue->id,
      ':clue_text' => $clue->clue_text,
      ':penalty' => $clue->penalty,
      ':enabled' => $clue->enabled
    );
    $sql = "UPDATE clues SET clue_text = :clue_text, penalty = :penalty, enabled = :enabled WHERE id = :id";
    $db->update($sql, $params, self::$_action_type);
  }

  /**
   * Deletes the row with the corresponding clue id.
   *
   * @param id $id clue id
   *
   * @return Nothing.
   */
  public static function deleteClue($id)
  {
    global $db;
    $params = array(':id' => $id);
    $sql = $sql = "DELETE FROM clues WHERE id = :id";
    $db->delete($sql, $params, self::$_action_type);
  }
}
