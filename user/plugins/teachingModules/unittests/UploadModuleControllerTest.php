<?php

require_once("config.inc.php");
require_once(HACKADEMIC_PLUGIN_PATH."teachingModules/class.TeachingModules.php");
require_once(HACKADEMIC_PLUGIN_PATH."teachingModules/class.ModuleContents.php");



class Upload extends PHPUnit_Framework_TestCase {
	
	protected function is_uploaded_file($filename = NULL){
		return true;
	}
	protected function move_uploaded_file ($filename, $destination){
		return true;
	}
    public function setUp(){
	 	
    }
	public function testUploadModule(){
		$_FILES['filename'] = "";
		$_FILES['path'] = "";
	}
	   public function tearDown(){ }
}