<?php
/**
 * Plugin Name: Challenge's clues
 * Plugin URI: http://github.com/pchaigno/hackademic/challenge-clues
 * Description: This plugin gives the possibility for the teachers to add and unlock clues. A penalty can be associated to each clue. The student won't have the penalty unless he reads the clue.
 * Version: 1.0
 * Author: Paul Chaignon
 * License: GPL2
 */
require_once('class.Clue.php');
require_once('class.UserCluesModel.php');
require_once(HACKADEMIC_PATH . "model/common/class.Session.php");

/**
 * Sets a custom made template for the specific page.
 * @param $new_path the path about to be set
 * @return string the new template
 */
function challenge_clues_set_admin_view_template($new_path) {
  if(string_contains('admin/view/editchallenge.tpl', $new_path)) {
    return 'user/plugins/challenge-clues/editchallenge.tpl';
  } else if(string_contains('admin/view/addchallenge.tpl', $new_path)) {
    return 'user/plugins/challenge-clues/addchallenge.tpl';
  }
}

/**
 * Sets a custom made template for the specific page.
 * @param $new_path the path about to be set
 * @return string the new template
 */
function challenge_clues_set_view_template($new_path) {
  if(string_contains('view/showChallenge.tpl', $new_path)) {
    return 'user/plugins/challenge-clues/showChallenge.tpl';
  }
}

/**
 * Retrieves the clues of a challenge to display them on the edit page.
 * @param $smarty the smarty object
 */
function challenge_clues_show_edit_challenge($smarty) {
  $challenge_id = $smarty->tpl_vars['challenge']->value->id;
  $clues = Clue::getClues($challenge_id);
  $smarty->assign('clues', $clues);
}

/**
 * Retrieves the clues of a challenge to display them for the student.
 * @param $smarty the smarty object
 */
function challenge_clues_show_challenge($smarty) {
  $user_id = Session::getLoggedInUserId();

  if(isset($_POST['clue']) && is_numeric($_POST['clue'])) {
  // The student asked to see a clue.
    $openedClue = Clue::getEnabledClue($_POST['clue']);
    if($openedClue != null) {
      UserCluesModel::addClue($user_id, $openedClue);
    }
  }

  $challenge_id = $smarty->tpl_vars['challenge']->value->id;
  $clues = Clue::getEnabledClues($challenge_id);
  UserCluesModel::markOpenedClues($user_id, $clues);
  $smarty->assign('clues', $clues);
}

/**
 * Adds the clues if any to the clue table.
 * @param $challenge_id the id of the challenge
 * @param $params the params to the query
 */
function challenge_clues_after_create_challenge($challenge_id, $params) {
  for($i=0; $i<$_POST['nb_clues']; $i++) {
    $clue = new Clue();
    $clue->id = $_POST['id'];
    $clue->clue_text = $_POST['clue_text'];
    $clue->penalty = $_POST['penalty'];
    $clue->enabled = isset($_POST['enabled']) && $_POST['enabled'];
    $clue->challenge = $challenge_id;
    Clue::addClue($clue);
  }
}

/**
 * Updates the clues of the challenge.
 * @param $params the params to the query
 */
function challenge_clues_after_update_challenge($params) {
  // Id of the clues still present (not deleted by the user).
  $cluesId = array();
  $allClues = Clue::getCluesId($params[':id']);

  for($i=0; $i<$_POST['nb_clues']; $i++) {
    $clue = new Clue();
    $clue->clue_text = $_POST['clue'.$i.'_text'];
    $clue->penalty = $_POST['clue'.$i.'_penalty'];
    $clue->enabled = $_POST['clue'.$i.'_state'] == 'enabled';
    $clue->challenge = $params[':id'];

    if(isset($_POST['clue'.$i.'_id']) && $_POST['clue'.$i.'_id']!='') {
    // Updates the clue:
      $clue->id = $_POST['clue'.$i.'_id'];
      Clue::updateClue($clue);
      $cluesId[] = $clue->id;
    } else {
    // Adds the new clue:
      Clue::addClue($clue);
    }
  }

  // Deletes the clues deleted by the user from the database:
  $deletedClues = array_diff($allClues, $cluesId);
  foreach($deletedClues as $id) {
    Clue::deleteClue($id);
  }
}

/**
 * Deletes the clues from the user-clues table,
 * then deletes the clues from the clue table.
 * This must be done before the challenge is
 * deleted to preserve the foreign key constraint.
 * @param $sql the base sql query
 * @param $params the params to the query
 */
function challenge_clues_before_delete_challenge($sql, $params) {
  UserCluesModel::deleteClue($params[':id']);
  Clue::deleteClue($params[':id']);
}

/**
 * Deletes the user from the user-clues table before the user table
 * to make sure the foreign key constraint is not broken.
 * @param $sql the base sql query
 * @param $params the params to the query
 */
function challenge_clues_before_delete_user($sql, $params) {
  UserCluesModel::deleteUser($params[':id']);
}

/**
 * Creates two tables when this plugin is enabled.
 * @param $plugin the plugin that was enabled
 */
function challenge_clues_enable_plugin($plugin) {
  if($plugin == 'challenge-clues/challenge-clues.php') {
    Clue::createTable();
    UserCluesModel::createTable();
  }
}

// Adds 'show' actions
Plugin::add_action('show_edit_challenge', 'challenge_clues_show_edit_challenge', 10, 1);
Plugin::add_action('show_show_challenge', 'challenge_clues_show_challenge', 10, 1);

// Adds 'CRUD' actions
Plugin::add_action('after_create_challenge', 'challenge_clues_after_create_challenge', 10, 2);
Plugin::add_action('after_update_challenge', 'challenge_clues_after_update_challenge', 10, 1);
Plugin::add_action('before_delete_challenge', 'challenge_clues_before_delete_challenge', 10, 2);
Plugin::add_action('before_delete_user', 'challenge_clues_before_delete_user', 10, 2);

// Adds action for enabling plugin
Plugin::add_action('enable_plugin', 'challenge_clues_enable_plugin', 10, 1);

// Adds filter to set custom form template
Plugin::add_filter('set_admin_view_template', 'challenge_clues_set_admin_view_template', 10, 1);
Plugin::add_filter('set_view_template', 'challenge_clues_set_view_template', 10, 1);

/**
 * Checks to see if the sub string is part of the original string
 *
 * @param $substring the substring you wish to look for
 * @param $string the string to search for the sub string in
 * @return true if $substring is found, otherwise false
 */
function string_contains($substring, $string) {
  $pos = strpos($string, $substring);
  return $pos > -1 ? true : false;
}