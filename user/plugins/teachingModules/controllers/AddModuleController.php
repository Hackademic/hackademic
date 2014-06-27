<?php

require_once(HACKADEMIC_PATH."model/common/class.Session.php");
require_once(HACKADEMIC_PATH."admin/model/class.Classes.php");
require_once(HACKADEMIC_PATH."admin/model/class.ArticleBackend.php");
require_once(HACKADEMIC_PATH."admin/controller/class.HackademicBackendController.php");
require_once(HACKADEMIC_PATH."model/common/class.Utils.php");
require_once(HACKADEMIC_PATH."admin/controller/class.AddChallengeController.php");

define("TEACHING_MODULES_FOLDER",'teaching_modules/');
class AddModuleController extends HackademicBackendController {

  private static $action_type = 'teachingModules_add_module';
  private $artifacts;
  private $module;

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
				header('Location: '.SOURCE_ROOT_PATH."?url=admin/managemodules&source=addModule");
			    }
			}
		}
		if(isset($_FILES['fupload'])) {
			$filename = $_FILES['fupload']['name'];
			$type = $_FILES['fupload']['type'];
			$name = explode('.', $filename);
//var_dump($name);//foomod.zip
			$source = $_FILES['fupload']['tmp_name'];
			$target = HACKADEMIC_PATH.TEACHING_MODULES_FOLDER. $name[0] . '/';
		
			if(!isset($name[1])) {
				$this->addErrorMessage("Please select a file");
				return $this->generateView(self::$action_type);
			}
		if(false === dir(HACKADEMIC_PATH.TEACHING_MODULES_FOLDER))
			mkdir(HACKADEMIC_PATH."teaching_modules/");

      mkdir($target);//challenges/foomod
      $saved_file_location = $target . $filename;//challenges/foomod/foomod.zip

//var_dump("filename:".$filename." source:".$source." type:".$type." name:".$name." target:".$target);
      if(move_uploaded_file($source, $target . $filename)) {
      	if( TRUE === $this->extract_zip($filename, $target) ){
      		$filename = split("\.zip", $filename);
      		if( TRUE === $this->validate_structure($target, $filename[0])){
					$this->module->date_added = date("Y-m-d H:i:s");
					$this->module->added_by = Session::getLoggedInUser(); 
					if (TeachingModule::exists($this->module)) {
						$this->addErrorMessage(" This Module Name already exists");
					}else{
						TeachingModule::add($this->module);
    	  			}
    	  			$this->module = TeachingModule::get_by_name($this->module->name);
      			//var_dump($this->artifacts);
    	  			$this->install_module();
   					$this->addSuccessMessage("Module Installed Succesfully");
     		}
	  	}
      }
	  	
	}
	return $this->generateView(self::$action_type);
}
	private static function rrmdir($dir) {
		foreach(glob($dir . '/*') as $file) {
			if(is_dir($file)) {
				self::rrmdir($file);
			} else {
				unlink($file);
			}
		}
		rmdir($dir);
	}
	
	private function extract_zip($file_to_open,$target){
		$zip = new ZipArchive();
		$x = $zip->open($target.$file_to_open);

		if($x === true) {
			$zip->extractTo($target);
			$zip->close();
			unlink($target.$file_to_open);
			return true;
			#deletes the zip file. We no longer need it.
		}else{
			$this->addErrorMessage("Could Not extract the zip");
			return false;
		}
	}
	private function validate_structure($target, $name){
		$fail = FALSE;
		if (!file_exists($target."$name".".xml")){
			//echo"<p>Waiting to find ";var_dump($target.$name);echo"</p>";
			$this->addErrorMessage("Not a valid challenge! Can't find XML file.");
			$fail = TRUE;
		}
		if($fail === TRUE){
			$this->rrmdir(HACKADEMIC_PATH."/".$name);
			return false;
		}
		
		var_dump(simplexml_load_file($target.$name."xml"));
		
		$xml = simplexml_load_file($target.$name.".xml");
		var_dump($xml);
		var_dump($target.$name.".xml");
		die();

		if ( !isset($xml->name) ){
			$this->addErrorMessage("The XML file is not valid, name missing.");
			self::rrmdir(HACKADEMIC_PATH."challenges/".$name);
			return false;
		}
		$success = false;
		$this->artifacts = array();
		foreach ($xml->artifact as $art){
			if("Article" == $art->type){
				$success = $this->load_article($art,$target);
			}elseif('Challenge' == $art->type){
				$success = $this->load_challenge($art,$target);
			}
		}
		if(!$success){
			$this->addErrorMessage("The XML file is not valid.");
			return false;
		}
	$this->module = new TeachingModule();
	$this->module->name = Utils::sanitizeInput($xml->name);
	return true;	
	}
	
	/* Loads an article in the artifacts array
	 * @param: $art  object(SimpleXMLElement)
	 * @returns false if something went wrong else true
	 */
	private function load_article($art,$target){
		if(!isset($art->name) || $art->name ==="")
			return false;
		if(!isset($art->pathname) || $art->pathname ==="")
			return false;
		
		$article = array();
		$article['type'] = 'a';
		$article['file'] = (string)$art->pathname;
		/*$article['content'] = validate that there is a file, open it and get the contents*/
		$article['artName'] = (string)$art->name;
		array_push($this->artifacts, $article);
		return TRUE;
	}
	
	/* Loads achallenge in the artifacts array
	 * @param: $art  object(SimpleXMLElement)
	* @returns false if something went wrong else true
	*/
	private function load_challenge($art,$target){
		if(!isset($art->name) || $art->name ==="")
			return FALSE;
		if(!isset($art->pathname) || $art->pathname ==="")
			return FALSE;

		$challenge = array();
		$challenge['type'] = 'c';
		$challenge['file'] =  $target.(string)$art->pathname;
		$challenge['target'] = $target.explode('/',(string)$art->pathname)[0]."/";
		$challenge['chalName'] = (string)$art->name;
		array_push($this->artifacts, $challenge);
		//var_dump($challenge);
		return TRUE;
	}
	
	private function install_module(){
		$util = new AddChallengeController();
		foreach($this->artifacts as $art){
			if($art['type'] === 'c'){
				var_dump($art);
				$data = $util->installChallenge($art['file'], $art['target'], $art['chalName']);
				$pkg_name = $art['chalName'];
				var_dump($data);
				if($data === true) {
					$pkg_name = $art['chalName'];
					$challenge = new Challenge();
					$challenge->title = $data['title'];
					$challenge->pkg_name = $pkg_name;
					$challenge->description = $data['description'];
					$challenge->author = $data['author'];
					$challenge->category = $data['category'];
					$challenge->date_posted = date("Y-m-d H-i-s");
					$challenge->level = $data['level'];
					$challenge->duration = $data['duration'];
					ChallengeBackend::addChallenge($challenge);
					$challenge = Challenge::getChallengeByPkgName($pkg_name);
					$artifact = new ModuleContents();
					$artifact->artifact_id = $challenge->id;
					$artifact->artifact_type = ARTIFACT_TYPE_CHALLENGE;
					$artifact->module_id = $this->module->id;
					ModuleContents::add($artifact);
				}elseif($data === false){
					$this->addErrorMessage("Could not install challenge ". $art['chalName']);
					return false;
				}
			}elseif($art['type'] === 'a'){
				$article = new Article();
				$article->content = $art['content'];
				$article->created_by = Session::getLoggedInUser();
				$article->date_posted = date("Y-m-d H:i:s");
				$article->is_published = 1;
				$article->title = $art['artName'];
				ArticleBackend::addArticle($article);
				$article = Article::getNarticles(null, null, $article->title);
				//var_dump($article);
				$artifact = new ModuleContents();
				$artifact->artifact_id = $challenge->id;
				$artifact->artifact_type = ARTIFACT_TYPE_CHALLENGE;
				$artifact->module_id = $this->module->id;
				ModuleContents::add($artifact);
			}
		}
		
	}
} 
