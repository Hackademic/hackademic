<?php

require_once("config.inc.php");
require_once(HACKADEMIC_PLUGIN_PATH."teachingModules/class.TeachingModules.php");
require_once(HACKADEMIC_PLUGIN_PATH."teachingModules/class.ModuleContents.php");
require_once(HACKADEMIC_PLUGIN_PATH."teachingModules/controllers/class.ManageModules.php");



class ManageModulesControllerTest extends PHPUnit_Framework_TestCase {

    public function setUp(){
    	$module = new TeachingModule();
    	$module->name = "TestModule1";
    	$module->date_added = "2014-06-15 12:19:16";
    	$module->added_by = 0;
    	 
    	TeachingModule::add($module);
    	$module = TeachingModule::get_by_name("TestModule1");
    	$_POST['modId'] = $module->id;
    }
	public function ManageModulesControllerTest(){
		$controller = new ManageModulesController();
		$_POST['action'] = 'del';
		$controller->go();
		$module = TeachingModule::get($module->id);
		assert(false === $module);
	}
    public function tearDown(){ }
}
