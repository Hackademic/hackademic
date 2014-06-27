<?php
/**
 *
 * Plugin Name: Teaching Modules
  * Description: 
 * Version: 1.1
 * Author: Spyros Gasteratos
require_once(HACKADEMIC_PLUGIN_PATH. 'teachingModules/class.ModuleContents.php');
 * License: GPL2
 *
 */

require_once(HACKADEMIC_PLUGIN_PATH.'teachingModules/class.TeachingModule.php');
require_once(HACKADEMIC_PLUGIN_PATH.'teachingModules/class.ModuleClasses.php');
require_once(HACKADEMIC_PLUGIN_PATH.'teachingModules/class.ModuleContents.php');

function setup(){
	Plugin::add_page("admin/managemodules", 'user/plugins/teachingModules/managemodules.php');
	Plugin::add_page("admin/addmodule", 'user/plugins/teachingModules/addmodule.php');
	Plugin::add_page("admin/managemodules/addmodule", 'user/plugins/teachingModules/addmodule.php');
	Plugin::add_page("admin/editmodule", 'user/plugins/teachingModules/editmodule.php');
	Plugin::add_menu_item('admin/managemodules', 1, 'Manage Modules', 0, 9);
}
function teardown(){
	Plugin::delete_page("admin/managemodules");
	Plugin::delete_page("admin/managemodules/addmodule");
	Plugin::delete_page("admin/editmodule");
	Plugin::delete_page("admin/addmodule");
	Plugin::delete_menu_item('admin/managemodules', 0);
}
/**
 * Sets a custom made template for the specific page.
 *
 * @param $new_path the path about to be set
 * @return string the new template
 */
function custom_uni_set_admin_view_template($new_path) {
  if(string_contains('admin/view/showclass.tpl', $new_path)) {
    return 'user/plugins/teachingModules/showclass.tpl';
  } else if(string_contains('admin/view/modulemanager.tpl', $new_path)) {
    return 'user/plugins/teachingModules/view/modulemanager.tpl';
  }else if(string_contains('admin/view/addmodule.tpl', $new_path)) {
    return 'user/plugins/teachingModules/view/addmodule.tpl';
  }else if(string_contains('admin/view/editmodule.tpl', $new_path)) {
    return 'user/plugins/teachingModules/view/editmodule.tpl';
  }
  
}
/**
 * Adds a module to the class if one is selected.
 *
 * @param $mid the module id
 * @param $params the parameters from the default form
 */
function custom_after_show_class($mid, $params) {
  if($_POST['mid'] != 'none' && $_GET['action'] === 'add') {
    ModuleClasses::add($_GET['class_id'], $mid);
  }else if($_POST['mid'] != 'none' && $_GET['action'] === 'delete') {
    $mc = new ModuleClasses();
    $mc->class_id = $_GET['class_id'];
    $mc->module_id = $_POST['mid'];
    $mc = ModuleClasses::get($mc);
    ModuleClasses::delete($mc);
  }
}

/**
 * Updates the challenge connected with the article.
 *
 * @param $params the parameters from the default form
 */
function custom_before_show_class($smarty) {
	//var_dump($_POST);
	
  if(isset($_POST['submit']) && isset($_POST['modules'])){	
  	ModuleClasses::add($_GET['id'], $_POST['modules']);
  	$contents = ModuleContents::get_by_module_id($_POST['modules']);
  	foreach($contents as $artifact){
  		if($artifact->artifact_type === ARTIFACT_TYPE_CHALLENGE){
  			ClassChallenges::addMembership($artifact->artifact_id,
  										 $_GET['id']);
  		}elseif($artifact->artifact_type === ARTIFACT_TYPE_ARTICLE){
  			/*ClassArticles::addMembership($artifact->artifact_id,
  										 $_GET['id']);*/
  		}
  	}
  }

  if(isset($_GET['action']) && $_GET['action'] === 'del' &&
  	 isset($_GET['mid'])){
	$moduleClass = new ModuleClasses();
	$moduleClass->module_id = $_GET['mid'];
	$moduleClass->class_id=$_GET['id'];
	$moduleClass = ModuleClasses::get_by_mod_class($moduleClass);
  	ModuleClasses::delete($moduleClass);
  }
  
  $modules = ModuleClasses::getModules($_GET['id']);
  $not_memberships = ModuleClasses::get_not_memberships($_GET['id']);
 
  if(false != $modules[0])
  	$smarty->assign('modules', $modules);
  if(false != $not_memberships)
  	$smarty->assign('modules_not_assigned', $not_memberships);
}

/**
 * Deletes the challenge connected with the article before the article
 * is deleted to make sure the FK restraint is not broken.
 *
 * @param $sql the sql that is about to be executed
 * @param $params the parameters from the default form
 */
 function custom_before_delete_class($params) {
	  ModuleClasses::deleteAllModulesForClass($_GET['class_id']);
}
/**
 *
 * @param $plugin the plugin that was enabled
 */
function custom_uni_enable_plugin($plugin) {
  if($plugin === 'teachingModules/teachingModules.php') {
    TeachingModule::createTable();
    ModuleContents::createTable();
    ModuleClasses::createTable();
    setup();
  }
}

function custom_uni_disable_plugin($plugin) {
	if($plugin === 'teachingModules/teachingModules.php') {
		TeachingModule::dropTable();
		ModuleClasses::dropTable();
		ModuleContents::dropTable();
		teardown();
	}
}

// Add 'show' actions
Plugin::add_action('after_show_class', 'custom_after_show_class', 10, 1);
Plugin::add_action('show_show_class', 'custom_before_show_class', 10, 1);
Plugin::add_action('before_delete_class', 'custom_before_delete_class', 10, 1);

// Add action for enabling plugin
Plugin::add_action('enable_plugin', 'custom_uni_enable_plugin', 10, 1);

// Add action for disabling plugin
Plugin::add_action('disable_plugin', 'custom_uni_disable_plugin', 10, 1);

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
