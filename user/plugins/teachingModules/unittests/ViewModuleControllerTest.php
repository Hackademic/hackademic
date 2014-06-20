<?php

require_once("config.inc.php");
require_once(HACKADEMIC_PLUGIN_PATH."teachingModules/class.TeachingModules.php");
require_once(HACKADEMIC_PLUGIN_PATH."teachingModules/class.ModuleContents.php");



class ViewModuleControllerTest extends PHPUnit_Framework_TestCase {

    public function setUp(){
    	$module = new TeachingModule();
    	$module->name = "TestModule1";
    	$module->date_added = "2014-06-15 12:19:16";
    	$module->added_by = 0;
    	
	 	TeachingModule::add($module);
    	$module = TeachingModule::get_by_name("TestModule1");
		$_GET['modId'] = $module->id;
    }
	public function testViewModuleController_view(){
		$controller = new ViewModuleController();
		$controller->go();
		//TODO assert that it loaded the correct module somehow assert()
	}
	
	public function testViewModuleController_delete(){
		$_GET['action'] = "del";
		$controller = new ViewModuleController();
		$controller->go();
		assert( false === TeachingModule::get($_GET['modId']));
		
	}
	
	public function testViewModuleController_add_challenge(){
		$contents = ModuleContents::get_by_module_id($_GET['modId']);
		
		assert( false === $contents );
		$_GET['action'] = "update";
		$_GET['name'] = "TestModule1";
		$_GET['challenge'] = 1;
		$controller = new ViewModuleController();
		$controller->go();

		$contents = ModuleContents::get_by_module_id($_GET['modId']);
		assert( 1 === $contents[0]->artifact_id );
		
		ModuleContents::delete($contents[0]);
	}

	public function testViewModuleController_add_article(){
		$contents = ModuleContents::get_by_module_id($_GET['modId']);
		assert( false === $contents );
		$_GET['action'] = "update";
		$_GET['name'] = "TestModule1";
		$_GET['aticle'] = 1;
		$controller = new ViewModuleController();
		$controller->go();
	
		$contents = ModuleContents::get_by_module_id($_GET['modId']);
		assert( 1 === $contents[0]->artifact_id );
	}

	
    public function tearDown(){ }
}