<?php
/**
 *
 * Hackademic-CMS/controller/class.ChallengeMenuController.php
 *
 * Hackademic Challenge Menu Controller
 * Class for creating the Challenge Main Menu
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
require_once(HACKADEMIC_PATH."controller/class.HackademicController.php");
require_once(HACKADEMIC_PATH."model/common/class.Debug.php");
require_once(HACKADEMIC_PATH."/admin/model/class.Classes.php");

class ChallengeListController extends HackademicController {

	public function go() {
		$username = $this->getLoggedInUser();
		$user = User::findByUserName($username);
		if (!$user) {
		    return;
		}
		//$challenges=Challenge::getChallengesFrontend($user->id);
		$res_array = $this->get_by_class($user);
		$challenges = $res_array['challenges'];
		$menu=array();
		$message = false;
		foreach( $challenges as $class_name => $class_challenges){
			$menu[$class_name] = array();
			foreach( $class_challenges as $challenge){//var_dump($challenge);
				$link = array ('id'=>$challenge->id,
											 'title'=>$challenge->title,
											 'availability'=>$challenge->availability,
											 'class_id' => $res_array['ids'][$class_name],
											 'url'=>'challenges/'.$challenge->pkg_name.'/index.php');
				array_push($menu[$class_name],$link);
				if ('private' == $challenge->availability){
					$message = true;
				}
			}

		}
		if($message)
			$this->addSuccessMessage("Note: Unclickable challenges are not yet available");

		$this->addToView('list', $menu);
		$this->setViewTemplate('challenge_list.tpl');
		return $this->generateView();
	}
	private function get_by_class($user){
		$result = array();
		$class_challenges = array();
		$classes = ClassMemberships::getMembershipsOfUser($user->id);
		foreach($classes as $cl){
			$result['ids'][$cl['name']] = $cl['class_id'];
			$class_challenges[$cl['name']] = ClassChallenges::getAllMemberships($cl['class_id']);
			foreach($class_challenges[$cl['name']] as $key=>$challenge){
				$class_challenges[$cl['name']][$key] = Challenge::getChallenge($challenge['challenge_id']);
			}
		}
		$result['challenges'] = $class_challenges;
		return $result;
	}
}
