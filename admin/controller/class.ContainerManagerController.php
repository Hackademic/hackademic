<?php

require_once(HACKADEMIC_PATH."/admin/controller/class.HackademicBackendController.php");

class ContainerManagerController extends HackademicBackendController {

	private static $action_type = 'manage_containers';

	public function go() {
		/*
		 * Logic goes here
		 * you will need to register variables to the view with
		 * $this->addToView('name of the expected var', $var);
		 * you print error messages like this
		 * $this->addErrorMessage("your err msg");
		 * and success msg
		 * $this->addSuccessMessage("your msg");
		 *
		 * */
		$this->setViewTemplate('containermanager.tpl');
		$this->generateView(self::$action_type);
	}
}
