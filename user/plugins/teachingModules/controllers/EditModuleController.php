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
						$artifact->artifact_type = ARTIFACT_TYPE_CHALLENGE;
						$artifact->artifact_id = $_POST['challenges'];
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
		if (isset($_GET['action']) && $_GET['action'] == "del") {
			if (isset($_POST['artid'])) {
				$artifact = ModuleContents::get($_POST['artid']);
				ModuleContents::delete($artifact);
				$this->addSuccessMessage("Article has been removed from the module succesfully");

			} else if (isset($_POST['cid'])) {
				$artifact = ModuleContents::get($_POST['cid']);
				ModuleContents::delete($artifact);
				$this->addSuccessMessage("Challenge has been deleted from the class succesfully");
			}
		}

		$articles = ModuleContents::get_module_articles($module->id);
		$challenges = ModuleContents::get_module_challenges($module->id);

		if($change)
			$module = TeachingModule::get($module->id);
/*
		var_dump($challenges_not_assigned);
		var_dump($challenges_assigned);
*/
		$challenges_not_assigned = ModuleContents::get_challenges_not_in_the_module($module->id);
		$articles_not_assigned = ModuleContents::get_articles_not_in_the_module($module->id);
		$this->addToView('module', $module);
		$this->addToView('challenges_not_assigned',$challenges_not_assigned);
		$this->addToView('articles_not_assigned',$articles_not_assigned);
		$this->addToView('challenges', $challenges_assigned);
		$this->addToView('articles', $articles_assigned);
		return $this->generateView(self::$action_type);
	}
}
