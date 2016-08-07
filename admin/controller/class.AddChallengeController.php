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

// -- Class Name : AddChallengeController
// -- Purpose : 
// -- Created On : 
class AddChallengeController extends HackademicBackendController {
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
	    
	    if ( !isset($xml->title) || !isset($xml->author)|| !isset($xml->description)|| !isset($xml->category)){
		$this->addErrorMessage("The XML file is not valid.");
		self::rrmdir(HACKADEMIC_PATH."challenges/".$name);
		return false;
	    }

	    $a = array(
		'title'=>$xml->title,
		'author'=>$xml->author,
		'description'=>$xml->description,
		'category'=>$xml->category
	    );
	    return $a;
	} else {
	    $this->addErrorMessage("There was a problem. Please try again!");
	    return false;
	}

    }

    public function go() {
	$this->setViewTemplate('addchallenge.tpl');
	
	if (isset($_GET['type']) && $_GET['type'] == "code") {
	    $add_type = "code";
	} else {
	    $add_type = "challenge";
	}

	
	if (isset($_POST['continue'])) {
	    
	    if ($_POST['title']=='') {
		$this->addErrorMessage("Title of the challenge should not be empty");
	    } elseif ($_POST['description']=='') {
		$this->addErrorMessage("Description should not be empty");
	    } elseif ($_POST['authors']=='') {
		$this->addErrorMessage("Authors field should not be empty");
	    } elseif ($_POST['category']=='') {
		$this->addErrorMessage("Category field should not be empty");
	    } else {
		$array = array (
		    'title' => $_POST['title'],
		    'description' => $_POST['description'],
		    'authors' => $_POST['authors'],
		    'category' => $_POST['category']
		);
		$_SESSION['challenge_arr'] = $array;
		$this->addSuccessMessage("Now Please upload the challenge code");
		$this->addToView('step', 'step2');
	    }

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
		    ChallengeBackend::addchallenge($data['title'],$pkg_name,$data['description'],$data['author'],$data['category'],$date_posted);
		    header('Location: '.SOURCE_ROOT_PATH."admin/pages/challengemanager.php?action=add");
		}

	    }

	}

	$this->addToView('type', $add_type);
	return $this->generateView();
    }

}