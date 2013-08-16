<?php
/**
 *
 * Hackademic-CMS/controller/class.FrontendMenuController.php
 *
 * Hackademic Frontend Menu Controller
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

class FrontendMenuController{

	public function go() {
		$menu = self::createMainMenu();
		return;
	}

	/**
	 * Create Main Menu
	 */
	protected function createMainMenu() {
		//$link1 = array ('title'=>'Home', 'url'=>'index.php');
		//$link2 = array ('title'=>'Challenges', 'url'=>'pages/challengelist.php');
		//$link3 = array ('title'=>'Rankings', 'url'=>'pages/ranking.php');
		//$link4 = array ('title'=>'Download','external'=>true,'url'=>'https://code.google.com/p/owasp-hackademic-challenges/');

		$menu = array(
			//	$link1,
			//	$link2,
			//	$link3//,
				//$link4
			     );
		return $menu;
	}
}
