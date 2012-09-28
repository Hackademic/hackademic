<?php
/**
 *
 * Hackademic-CMS/controller/class.UserMenuController.php
 *
 * Hackademic User Menu Controller
 * Class for creating the frontend Main Menu
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

class UserMenuController{

	public function go() {
		$menu = self::createMainMenu();
		return $menu;
	}

	/**
	 * Create Main Menu
	 */
	protected function createMainMenu() {
		if(Session::isAdmin()){
			$link0 = array ('title'=>'Home', 'url'=>'admin/');
			$link1 = array ('title'=>'Add New Articles', 'url'=>'admin/pages/addarticle.php');
			$link2 = array ('title'=>'Article Manager', 'url'=>'admin/pages/articlemanager.php');
			$link3 = array ('title'=>'Users/Classes', 'url'=>'admin/pages/usermanager.php');
			$link4 = array ('title'=>'Add New Challenge', 'url'=>'admin/pages/addchallenge.php?type=code');
			$link5 = array ('title'=>'Challenge Manager', 'url'=>'admin/pages/challengemanager.php');
			$link6 = array ('title'=>'Logout', 'url'=>'pages/logout.php');

			$menu = array(
					$link0,
					$link1,
					$link2,
					$link3,
					$link4,
					$link5,
					$link6
				     );
		} elseif(Session::isTeacher()) {
			/*$link1 = array ('title'=>'Admin Dashboard', 'url'=>'admin');
			$link2 = array ('title'=>'Article Manager', 'url'=>'admin/pages/articlemanager.php');
			$link3 = array ('title'=>'User Manager', 'url'=>'admin/pages/usermanager.php');
			$link4 = array ('title'=>'Create Class', 'url'=>'admin/pages/manageclass.php');
			$link5 = array ('title'=>'Add Challenge', 'url'=>'admin/pages/addchallenge.php');
			$link6 = array ('title'=>'Monitor Students', 'url'=>'pages/progress.php');
			$link7 = array ('title'=>'Logout', 'url'=>'pages/logout.php');

			$menu = array(
					$link1,
					$link2,
					$link3,
					$link4,
					$link5,
					$link6,
					$link7
				     );*//*TODO make both admin and teacher menus more sensible*/
			$link0 = array ('title'=>'Admin Dashboard', 'url'=>'admin/');
			$link1 = array ('title'=>'Add New Articles', 'url'=>'admin/pages/addarticle.php');
			$link2 = array ('title'=>'Article Manager', 'url'=>'admin/pages/articlemanager.php');
			$link3 = array ('title'=>'Users/Classes', 'url'=>'admin/pages/usermanager.php');
			$link4 = array ('title'=>'Add New Challenge', 'url'=>'admin/pages/addchallenge.php?type=code');
			$link5 = array ('title'=>'Challenge Manager', 'url'=>'admin/pages/challengemanager.php');
			$link6 = array ('title'=>'Logout', 'url'=>'pages/logout.php');

			$menu = array(
					$link0,
					$link1,
					$link2,
					$link3,
					$link4,
					$link5,
					$link6
				     );
		} else {$link0 = array ('title'=>'Home', 'url'=>'index.php');
			$link1 = array ('title'=>'Progress Report', 'url'=>'pages/progress.php');
			$link2 = array ('title'=>'Ranking', 'url'=>'pages/ranking.php');
			$link3 = array ('title'=>'Logout', 'url'=>'pages/logout.php');
			$link4 = array ('title'=>'Challenges', 'url'=>'pages/challengelist.php');
			/*$link5 = array ('title'=>'Global Rankings', 'url'=>'pages/ranking.php');*/
			$menu = array(
					$link0,
					$link1,
					$link2,
					$link4,
					/*$link5,*/
					$link3

				     );
		}
		return $menu;
	}
}

