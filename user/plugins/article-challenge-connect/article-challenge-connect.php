<?php
/**
 *
 * Plugin Name: Article Challenge Connect
 * Plugin URI: http://example.com/article-challenge-connect
 * Description: This plugin connects articles to challenges. It is solely meant as a demonstration on how a plugin could be created using the Hackademic Challenges API and should not be used in a production environment since it lacks proper testing, security and quality assurances. You are encouraged to use it as a base for developing your own custom plugins.
 * Version: 1.1
 * Author: Daniel Kvist
 * Author URI: http://danielkvist.net
 * License: GPL2
 *
 */

require_once('class.ArticleChallengeModel.php');

/**
 * Sets a custom made template for the specific page.
 *
 * @param $new_path the path about to be set
 * @return string the new template
 */
function custom_uni_set_admin_view_template($new_path) {
  if(string_contains('admin/view/editor.tpl', $new_path)) {
    return 'user/plugins/article-challenge-connect/editor.tpl';
  } else if(string_contains('admin/view/articlemanager.tpl', $new_path)) {
    return 'user/plugins/article-challenge-connect/articlemanager.tpl';
  } else if(string_contains('admin/view/editarticle.tpl', $new_path)) {
    return 'user/plugins/article-challenge-connect/editarticle.tpl';
  }
}

/**
 * Adds a challenge to the article if a challenge is selected.
 *
 * @param $aid the article id
 * @param $params the parameters from the default form
 */
function custom_uni_after_create_article($aid, $params) {
  if($_POST['cid'] != 'none') {
    ArticleChallengeModel::add($aid, $_POST['cid']);
  }
}

/**
 * Updates the challenge connected with the article.
 *
 * @param $params the parameters from the default form
 */
function custom_uni_after_update_article($params) {
  if($_POST['cid'] != 'none') {
    if(ArticleChallengeModel::exists($params[':id'])) {
      ArticleChallengeModel::update($params[':id'], $_POST['cid']);
    } else {
      ArticleChallengeModel::add($params[':id'], $_POST['cid']);
    }
  } else {
    ArticleChallengeModel::delete($params[':id']);
  }
}

/**
 * Deletes the challenge connected with the article before the article
 * is deleted to make sure the FK restraint is not broken.
 *
 * @param $sql the sql that is about to be executed
 * @param $params the parameters from the default form
 */
function custom_uni_before_delete_article($sql, $params) {
  ArticleChallengeModel::delete($params[':id']);
}

/**
 * Fetches the challenges that are to be displayed on the
 * add article page.
 *
 * @param $smarty
 */
function custom_uni_show_add_article($smarty) {
  $username = $smarty->tpl_vars['logged_in_user']->value;
  $user_id = User::findByUserName($username)->id;
  $smarty->assign('challenges', Challenge::getChallengesFrontend($user_id));
}

/**
 * Fetches the challenges that are to be displayed on the
 * add article page and sets the selected challenge id in the
 * smarty template vars.
 *
 * @param $smarty
 */
function custom_uni_show_edit_article($smarty) {
  $username = $smarty->tpl_vars['logged_in_user']->value;
  $user_id = User::findByUserName($username)->id;
  $smarty->assign('challenges', Challenge::getChallengesFrontend($user_id));
  $aid = $smarty->tpl_vars['article']->value->id;
  $entry = ArticleChallengeModel::get($aid);
  $smarty->assign('selected_cid', $entry['cid']);
}

/**
 * Creates a table when this plugin is enabled.
 *
 * @param $plugin the plugin that was enabled
 */
function custom_uni_enable_plugin($plugin) {
  if($plugin == 'article-challenge-connect/article-challenge-connect.php') {
    ArticleChallengeModel::createTable();
  }
}

/**
 * Adds challenges to the template that shows articles
 *
 * @param $smarty
 */
function custom_uni_show_article_manager($smarty) {
  foreach($smarty->tpl_vars['articles']->value as $article) {
    $row = ArticleChallengeModel::get($article->id);
    $article->challenge = Challenge::getChallenge($row['cid']);
  }
}

// Add 'show' actions
Plugin::add_action('show_add_article', 'custom_uni_show_add_article', 10, 1);
Plugin::add_action('show_edit_article', 'custom_uni_show_edit_article', 10, 1);
Plugin::add_action('show_article_manager', 'custom_uni_show_article_manager', 10, 1);

// Add 'CRUD' actions
Plugin::add_action('after_create_article', 'custom_uni_after_create_article', 10, 2);
Plugin::add_action('after_update_article', 'custom_uni_after_update_article', 10, 1);
Plugin::add_action('before_delete_article', 'custom_uni_before_delete_article', 10, 2);

// Add action for enabling plugin
Plugin::add_action('enable_plugin', 'custom_uni_enable_plugin', 10, 1);

// Add filter to set custom form template
Plugin::add_filter('set_admin_view_template', 'custom_uni_set_admin_view_template', 10, 1);

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

/**
 * Debugging function for printing objects and arrays.
 *
 * @param $obj the object/array to print
 */
function pretty_print($obj) {
  print '<pre>';
  print_r($obj);
  print '</pre>';
}
