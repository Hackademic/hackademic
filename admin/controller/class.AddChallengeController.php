<?php
/**
 *
 * Hackademic-CMS/admin/controller/class.AddChallengeController.php
 *
 * Hackademic Add Challenge Controller
 * Class for the Add Challenge page in Backend
 *
 * Copyright (c) 2012 OWASP
 *
 * LICENSE:
 *
 * This file is part of Hackademic CMS (https://www.owasp.org/index.php/OWASP_Hackademic_Challenges_Project).
 *
 * Hackademic CMS is free software: you can redistribute it and/or modify it under the terms of the GNU General Public
 * License as published by the Free Software Foundation, either version 2 of the License, or (at your option) any
 * later version.
 *
 * Hackademic CMS is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
 * details.
 *
 * You should have received a copy of the GNU General Public License along with Hackademic CMS.  If not, see
 * <http://www.gnu.org/licenses/>.
 *
 *
 * @author Pragya Gupta <pragya18nsit[at]gmail[dot]com>
 * @author Konstantinos Papapanagiotou <conpap[at]gmail[dot]com>
 * @license http://www.gnu.org/licenses/gpl.html
 * @copyright 2012 OWASP
 *
 */
require_once(HACKADEMIC_PATH."admin/model/class.ChallengeBackend.php");
require_once(HACKADEMIC_PATH."admin/controller/class.HackademicBackendController.php");
require_once(HACKADEMIC_PATH."model/common/class.Utils.php");

// -- Class Name : AddChallengeController
// -- Purpose :
// -- Created On :
class AddChallengeController extends HackademicBackendController {

	public $title;
	public $authors;
	public $category;
	public $level;
	public $duration;
	public $description;

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

    public function installChallenge($file_to_open,$target,$name) {
	$zip = new ZipArchive();
	$x = $zip->open($file_to_open);

	if ($x === true) {
	    $zip->extractTo($target);
	    $zip->close();
	    unlink($file_to_open);
	    #deletes the zip file. We no longer need it.

	    if (isset($_GET['type']) && $_GET['type'] == "code") {
		$xml_exists = 1;
	    } else {
		$xml_exists = file_exists($target."$name".".xml");
	    }


	    if (!file_exists($target."index.php") || !$xml_exists) {

		if (!file_exists($target."index.php")) {
		    $this->addErrorMessage("Not a valid challenge! Index.php file doesn't exist");

		    if (isset($_GET['type']) && $_GET['type'] == "code") {
			$this->addToView('step', 'step2');
		    }

		} else {
		    $this->addErrorMessage("Not a valid challenge! Can't find XML file.");
		}

		self::rrmdir(HACKADEMIC_PATH."challenges/".$name);
		return false;
	    }


	    if (isset($_GET['type']) && $_GET['type'] == "code") {
		return $_SESSION['challenge_arr'];
	    }

	    $xml = simplexml_load_file($target."$name".".xml");

	    if ( !isset($xml->title) || !isset($xml->author)|| !isset($xml->description)|| !isset($xml->category)||
		 !isset($xml->level)|| !isset($xml->duration)){
		$this->addErrorMessage("The XML file is not valid.");
		self::rrmdir(HACKADEMIC_PATH."challenges/".$name);
		return false;
	    }

	    $a = array(
		'title'=>Utils::sanitizeInput($xml->title),
		'author'=>Utils::sanitizeInput($xml->author),
		'description'=>$xml->description,//Todo make sure its only html here and no javascript or other possibly malicious stuff
		'category'=>Utils::sanitizeInput($xml->category),
		'level'=>Utils::sanitizeInput($xml->level),
		'duration'=>Utils::sanitizeInput($xml->duration)
	    );
	    return $a;
	} else {
	    $this->addErrorMessage("There was a problem. Please try again!");
	    return false;
	}

    }

    public function go() {
	$this->setViewTemplate('addchallenge.tpl');
	$this->cache_values();
	if (isset($_GET['type']) && $_GET['type'] == "code") {
	    $add_type = "code";
	} else {
	    $add_type = "challenge";
	}


	if (isset($_POST['continue'])) {
	    $this->cache_values();
	    if ($_POST['title']=='') {
		$e_msg = "Title of the challenge should not be empty";
		$error = true;
	    } elseif ($_POST['description']=='') {
		$e_msg = "Description should not be empty";
		$error = true;
	    } elseif ($_POST['authors']=='') {
		$e_msg = "Authors field should not be empty";
		$error = true;
	    } elseif ($_POST['category']=='') {
		$e_msg = "Category field should not be empty";
		$error = true;
	    } elseif ($_POST['level']=='') {
		$e_msg = "Level field should not be empty";
		$error = true;
	    } elseif ($_POST['duration']=='') {
		$e_msg = "Duration field should not be empty";
		$error = true;
	    }
	     else {
		$array = array (
		    'title' => Utils::sanitizeInput($_POST['title']),
		    'description' => $_POST['description'],
		    'authors' => Utils::sanitizeInput($_POST['authors']),
		    'category' => Utils::sanitizeInput($_POST['category']),
		    'level' => Utils::sanitizeInput($_POST['level']),
		    'duration' => Utils::sanitizeInput($_POST['duration'])
		);
		$_SESSION['challenge_arr'] = $array;
		$this->addSuccessMessage("Now Please upload the challenge code");
		$this->addToView('step', 'step2');
	    }
	$new_msg = $e_msg;
	if($error){
		if(defined('EXAMPLE_CHALLENGE') && EXAMPLE_CHALLENGE != ""){
			$path = SOURCE_ROOT_PATH.EXAMPLE_CHALLENGE;
			$new_msg = "<em>".$e_msg."</em>
			<p>For an example on how to build challenges please consult <a href=\" ".$path."\">The Example Challenge</a></p>";}
		}
		$this->addErrorMessage($new_msg);
	}


	if(isset($_FILES['fupload'])) {
	    $filename = $_FILES['fupload']['name'];
	    $source = $_FILES['fupload']['tmp_name'];
	    $type = $_FILES['fupload']['type'];
	    $name = explode('.', $filename);
	    $target = HACKADEMIC_PATH."challenges/". $name[0] . '/';

	    if(!isset($name[1])) {
		$this->addErrorMessage("Please select a file");
		return $this->generateView();
	    }


	    if(isset($name[0])) {
		$challenge=ChallengeBackend::doesChallengeExist($name[0]);

		if($challenge==true){

		    if (isset($_SESSION['challenge_arr'])) {
			$this->addToView('step', 'step2');
		    } else {
			$this->addToView('type', $add_type);
		    }

		    $this->addErrorMessage("This file already exists!!");
		    return $this->generateView();
		}

	    }

	    $okay = strtolower($name[1]) == 'zip' ? true :
	    false;

	    if(!$okay) {

		if (isset($_SESSION['challenge_arr'])) {
		    $this->addToView('step', 'step2');
		} else {
		    $this->addToView('type', $add_type);
		}

		$this->addErrorMessage("Please choose a zip file!");
		return $this->generateView();
	    }

	    mkdir($target);
	    $saved_file_location = $target . $filename;

	    if(move_uploaded_file($source, $target . $filename)) {
		$data=$this->installChallenge($saved_file_location,$target,$name[0]);

		if($data==true){
		    $pkg_name =$name[0];
		    $date_posted = date("Y-m-d H-i-s");
		    ChallengeBackend::addchallenge($data['title'],$pkg_name,$data['description'],$data['author'],$data['category'],$date_posted,
						   $data['level'], $data['duration']);
		    header('Location: '.SOURCE_ROOT_PATH."admin/pages/challengemanager.php?action=add");
		}

	    }

	}

	$this->addToView('type', $add_type);
	return $this->generateView();
    }

	public function cache_values(){
		if(isset($_POST['title']))
			$this->title = Utils::sanitizeInput($_POST['title']);
		if(isset($_POST['description']))
			$this->description = $_POST['description'];
		if(isset($_POST['authors']))
			$this->authors = Utils::sanitizeInput($_POST['authors']);
		if(isset($_POST['category']))
			$this->category = Utils::sanitizeInput($_POST['category']);
		if(isset($_POST['level']))
			$this->level = Utils::sanitizeInput($_POST['level']);
		if(isset($_POST['duration']))
			$this->duration = Utils::sanitizeInput($_POST['duration']);

		$this->addToView('cached', $this);

	}

}
