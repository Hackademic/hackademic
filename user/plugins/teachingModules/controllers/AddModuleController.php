<?php

require_once(HACKADEMIC_PATH."model/common/class.Session.php");
require_once(HACKADEMIC_PATH."admin/model/class.Classes.php");
require_once(HACKADEMIC_PATH."/admin/controller/class.HackademicBackendController.php");
require_once(HACKADEMIC_PATH."model/common/class.Utils.php");

class AddModuleController extends HackademicBackendController {

  private static $action_type = 'teachingModules_add_module';

	public function go() {
		$this->setViewTemplate('addmodule.tpl');
		if(isset($_POST['submit'])) {
			if ($_POST['modulename']=='') {
				$this->addErrorMessage("Name of the Module should not be empty");
			} else {
				$module = new TeachingModule();
				$module->name = Utils::sanitizeInput($_POST['modulename']);
				$module->date_added = date("Y-m-d H:i:s");
				$module->added_by = Session::getLoggedInUser(); 
				
				if (TeachingModule::exists($module)) {
					$this->addErrorMessage(" This Module Name already exists");
				}else{
					TeachingModule::add($module);
				header('Location: '.SOURCE_ROOT_PATH."?url=admin/managemodule&source=addclass");
			    }
			}
		}
		$this->generateView(self::$action_type);
	}
} 