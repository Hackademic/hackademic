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
class ChallengeListController extends HackademicController {

	public function go() {
		$username = $this->getLoggedInUser();
		$user = User::findByUserName($username);
		if (!$user) {
		    return;
		}
		$challenges=Challenge::getChallengesFrontend($user->id);
		$menu=array();
		foreach( $challenges as $challenge){
			$link = array ('id'=>$challenge->id, 'title'=>$challenge->title,
				       'url'=>'challenges/'.$challenge->pkg_name.'/index.php',
				       'availability'=>$challenge->availability);
			array_push($menu,$link);
			
			if ('private' == $challenge->availability){
				
				$message = true;
			}
		}
		if($message)
			$this->addSuccessMessage("Note: Unclickable challenges are not yet available");

		$this->addToView('list', $menu);
		$this->setViewTemplate('challenge_list.tpl');
		return $this->generateView();
	}
}
