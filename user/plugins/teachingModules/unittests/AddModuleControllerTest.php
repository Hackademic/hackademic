<?php

require_once("config.inc.php");
require_once(HACKADEMIC_PLUGIN_PATH."teachingModules/class.TeachingModules.php");
require_once(HACKADEMIC_PLUGIN_PATH."teachingModules/class.ModuleContents.php");



class AddModuleControllerTest extends PHPUnit_Framework_TestCase {

    public function setUp(){
	 $_POST['modname'] = "TestModule1";
	 $_POST['articles'] =array(1,2,3);
	 $_POST['challenges'] = array(1,2,3,4);
    }
	public function testAddModuleController(){
		$controller = new AddModuleController();
		$controller->go();
		$module = TeachingModule::get_by_name("TestModule1");
		assert(false != $module);

		$contents = ModuleContents::get_by_module_id($module->id);
		
		assert( false != $contents );
		assert( isarray($contents) );
		assert( 7 === count($contents) );
		$challenges = $articles = 0;
		
		foreach( $contents as $artifact){
			if( ARTIFACT_TYPE_CHALLENGE === $artifact->artifact_type){
				$challenges++;
				assert(in_array($artifact->$artifact_id, $_GET['challenges']));
			}else{
				$articles++;
				assert(in_array($artifact->$artifact_id, $_GET['articles']));
			}
		}
		assert( 3 === $articles );
		assert( 4 === $challenges );
	}
    public function tearDown(){ }
}
?>