<?php
/**
 *
 * Hackademic-CMS/model/common/class.Session.php
 *
 * Hackademic Session Class
 * The class that manages logged-in Hackademic users' sessions via the web.
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
require_once(HACKADEMIC_PATH."/model/common/class.User.php");
class Session {

	/**
	 * @return bool Is user logged into SocialCalc
	 */
	public static function isLoggedIn() {
		if (isset($_SESSION['hackademic_user'])) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * @return bool Is user logged into Hackademic an admin
	 */
	public static function isAdmin() {
		if (isset($_SESSION['hackademic_user_type'])&&($_SESSION['hackademic_user_type']==1)){
			return true;
		} else {
			return false; 
		}	       
	}

	public static function isTeacher() {
		if (isset($_SESSION['hackademic_user_type'])&&($_SESSION['hackademic_user_type']==2)){
			return true;
		} else {
			return false; 
		}	       
	}

	/**
	 * Complete login action
	 * @param Owner $owner
	 */
	public static function completeLogin($owner) {
		User::updateLastVisit($owner->username);
		$_SESSION['hackademic_user'] = $owner->username;
		$_SESSION['hackademic_user_type'] = $owner->type;
		$_SESSION['hackademic_path'] = HACKADEMIC_PATH;
	}
	/**
	 * Check password
	 * @param str $pwd Password
	 * @param str $result Result
	 * @return bool Whether or submitted password matches check
	 */
	public function pwdCheck($pwd, $result) {
		if ($this->sha1pwd($pwd) == $result || $this->md5pwd($pwd) == $result) {
			return true;
		} else {
			return false;
		}
	}
	/**
	 *
	 * @param str $pwd Password
	 * @return str MD5-hashed password
	 */
	public function md5pwd($pwd) {
		return md5($pwd);
	}

	/**
	 * @param str $pwd Password
	 * @return str SHA1-hashed password
	 */
	private function sha1pwd($pwd) {
		return sha1($pwd);
	}

	/**
	 * @return str Currently logged-in SocialCalc username (email address)
	 */
	public static function getLoggedInUser() {
		if (self::isLoggedIn()) {
			return $_SESSION['hackademic_user'];
		} else {
			return null;
		}
	}

	/**
	 * Log out
	 */
	public static function logout() {
		unset($_SESSION['hackademic_user']);
		unset($_SESSION['hackademic_user_type']);
		session_destroy();      
	}
}
