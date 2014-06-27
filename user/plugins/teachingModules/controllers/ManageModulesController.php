<?php

require_once("config.inc.php");
require_once(HACKADEMIC_PLUGIN_PATH."teachingModules/class.TeachingModule.php");
require_once(HACKADEMIC_PLUGIN_PATH."teachingModules/class.ModuleContents.php");
require_once(HACKADEMIC_PATH."admin/controller/class.HackademicBackendController.php");

class ManageModulesController extends HackademicBackendController {

  private static $action_type = 'teaching_modules_manager';

	public function go() {
		if (isset($_GET["source"]) && ($_GET["source"]=="del")) {
			$module = new TeachingModule();
			$module->id = $_GET['id'];
			
			TeachingModule::delete($module);
			$this->addSuccessMessage("Module has been deleted succesfully");
		} elseif(isset($_POST["action"]) && ($_POST["action"]=="addmodule")) {
		    $this->addSuccessMessage("Module has been created succesfully");
		}
		if (isset($_GET['search']) && isset($_GET['category']) && $_GET['search']!='' && $_GET['category']!='') {
			$total_pages = TeachingModule::getNumberOfModules($_GET['search'], $_GET['category']);
		} else {
			$total_pages =TeachingModule::getNumberOfModules();


		}
		if (isset($_GET['limit']) && $_GET['limit']!="") {
			$limit =$_GET['limit'];
		}
		else {
			$limit=25;
		}
		$targetpage = SOURCE_ROOT_PATH."?url=admin/viewmodule";
		$stages = 3;
		$page=0;
		if(isset($_GET['page'])) {
			$page=$_GET['page'];
		}
		if($page) {
			$start = ($page - 1) * $limit; 
		} else {
			$start = 0;
		}	

		// Initial page num setup
		if ($page == 0){$page = 1;}
		$prev = $page - 1;	
		$next = $page + 1;							
		$lastpage = ceil($total_pages/$limit);		
		$LastPagem1 = $lastpage - 1;					

		$pagination = array (
				'lastpage' => $lastpage,
				'page' => $page,
				'targetpage' => $targetpage,
				'prev' => $prev,
				'next' => $next,
				'stages' => $stages,
				'last_page_m1' => $LastPagem1
				);
		if (isset($_GET['search']) && isset($_GET['category']) && $_GET['search']!='' && $_GET['category']!='') {
			$modules= TeachingModule::getNModules($start,$limit,$_GET['search'],$_GET['category']);
		} else {
			$modules = TeachingModule::getNModules($start, $limit);
		}
		if (isset($_GET['search'])) {
			$this->addToView('search_string', $_GET['search']);
		}
		//var_dump($classes);
		//var_dump($modules);
		$empty = array();
		if(false != $modules)
			$this->addToView('modules', $modules);
		else 
			$this->addToView('modules', $empty);
		$this->addToView('total_pages', $total_pages);
		$this->addToView('pagination', $pagination);
		$this->setViewTemplate('modulemanager.tpl');
		$this->generateView(self::$action_type);
	}
}

?>
