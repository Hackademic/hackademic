<?php

require_once(HACKADEMIC_PATH."admin/model/class.ClassMemberships.php");
require_once(HACKADEMIC_PATH."admin/model/class.ClassChallenges.php");
require_once(HACKADEMIC_PATH."admin/model/class.Classes.php");
require_once(HACKADEMIC_PATH."admin/controller/class.HackademicBackendController.php");
require_once(HACKADEMIC_PATH."model/common/class.Challenge.php");
require_once(HACKADEMIC_PATH."model/common/class.Utils.php");
require_once(HACKADEMIC_PATH."model/common/class.ScoringRule.php");

class EditModuleController extends HackademicBackendController {

  private static $action_type = 'teaching_modules_edit';

	public function go() {
		$this->setViewTemplate('editmodule.tpl');
		$module = new TeachingModule();

		if (!isset($_GET['id'])) {
			header('Location: '.SOURCE_ROOT_PATH."?url=admin/managemodules.tpl");
		}
		$module->id = $_GET['id'];
		$id = $module->id;
		$module = TeachingModule::get($module->id);
		$change = false;

		if(isset($_POST['submit'])) {
			if(isset($_POST['updatename'])) {
				if ($_POST['updatename']=='') {
					header('Location: '.SOURCE_ROOT_PATH."?url=admin/editmodule&id=$module->id&action=editerror");
				}
				else {
					if ($_POST['challenges'] !='default') {
						$artifact = new ModuleContents();
						$artifact->module_id = $module->id;
						$artifact->artifact_type = ARTIFACT_TYPE_CHALLENGE;
						$artifact->artifact_id = $_POST['challenges'];
						ModuleContents::add($artifact);
						$this->updateClasses($artifact,'add');
						$this->addSuccessMessage("Challenge has been added succesfully");
					}
					if ($_POST['articles'] !='default') {
						$artifact = new ModuleContents();
						$artifact->module_id = $module->id;
						$artifact->artifact_type = ARTIFACT_TYPE_ARTICLE;
						$artifact->artifact_id = $_POST['articles'];
						ModuleContents::add($artifact);
						$this->addSuccessMessage("Challenge has been added succesfully");
					}
					if($_POST['updatename'] != $module->name){
						$change = true;
						$module->name = Utils::sanitizeInput($_POST['updatename']);
						TeachingModule::update($module);
						header('Location: '.SOURCE_ROOT_PATH."?url=admin/editmodule&id=$module->id&action=editsuccess&message=cname");
					}
				}
			}
		}
		if (isset($_GET['action']) && $_GET['action'] == "editerror") {
			$this->addErrorMessage("Module name should not be empty");
		}
		if (isset($_GET['action']) && $_GET['action'] == "editsuccess") {
			$this->addSuccessMessage("Module name updated successfully");
		}
		if (isset($_GET['action']) && $_GET['action'] === "del") {
			if (isset($_GET['aid'])) {
				$artifact = new ModuleContents();
				$artifact->module_id = $id;
				$artifact->artifact_id = $_GET['aid'];

				$artifact = ModuleContents::get_id($artifact);
				$this->updateClasses($artifact,'del');
				ModuleContents::delete($artifact);
				$this->addSuccessMessage("Article has been removed from the module succesfully");

			} else if (isset($_GET['cid'])) {
				$artifact = new ModuleContents();
				$artifact->module_id = $id;
				$artifact->artifact_id = $_GET['cid'];

				$artifact = ModuleContents::get_id($artifact);
				//$artifact->id = $artifact2->id;
				
//				echo '<p>Artifact';var_dump($artifact);echo'</p>';
//				echo '<p>Artifact2';var_dump($artifact2);echo'</p>';
				
				$this->updateClasses($artifact,'del');
				ModuleContents::delete($artifact);
				$this->addSuccessMessage("Challenge has been deleted from the class succesfully");
			}
		}

		$articles = ModuleContents::get_module_articles($module->id);
		$challenges = ModuleContents::get_module_challenges($module->id);
		$challenges_not_assigned = ModuleContents::get_challenges_not_in_the_module($module->id);
		$articles_not_assigned = ModuleContents::get_articles_not_in_the_module($module->id);

		$empty = array();
		if($change)
			$module = TeachingModule::get($module->id);

		if(false != $module)
			$this->addToView('module', $module);
		else 
			$this->addToView('module', $empty);
		if(false != $challenges_not_assigned)
			$this->addToView('challenges_not_assigned',$challenges_not_assigned);
		else
			$this->addToView('challenges_not_assigned', $empty);
		if(false != $articles_not_assigned)
			$this->addToView('articles_not_assigned',$articles_not_assigned);
		else 
			$this->addToView('articles_not_assigned', $empty);
		if(false != $challenges)
			$this->addToView('challenges', $challenges);
		else
			$this->addToView('challenges', $empty);
		if(false != $articles)
			$this->addToView('articles', $articles);
		else
			$this->addToView('articles', $empty);

		return $this->generateView(self::$action_type);
	}
	/*
	 * Add/remove The artifact from the classes that have this module assigned
	 * @param: $artifact a module_contents type object that should be added/removed from classes
	 *         $op to add or to remove the artifact
	 */
	private function updateClasses($artifact, $op){
		$classes = ModuleClasses::getClasses($artifact->module_id);
		//var_dump($op);
		if('add' === $op){
			if(ARTIFACT_TYPE_CHALLENGE === $artifact->artifact_type){
				foreach($classes as $class){
					ClassChallenges::addMembership($artifact->artifact_id, $class->id);
				}		
			}elseif(ARTIFACT_TYPE_ARTICLE === $artifact->artifact_type){
				/*ClassArticles::addMembership($artifact->artifact_id, $class->id);*/
			}
		}elseif('del' === $op){
			//var_dump($artifact);
			if(ARTIFACT_TYPE_CHALLENGE == $artifact->artifact_type){
				//var_dump("called");
				//var_dump($classes);
				foreach($classes as $class){
					if( false === ClassChallenges::deleteMembership($artifact->artifact_id, $class->id))
					echo"";/**/
				}
			}elseif(ARTIFACT_TYPE_ARTICLE === $artifact->artifact_type){
				/*ClassArticles::deleteMembership($artifact->artifact_id, $class->id);*/
			}
		}
			
	}
}
