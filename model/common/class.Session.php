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
require_once(HACKADEMIC_PATH."/esapi/class.Esapi_Utils.php");
class Session {
	
	/*
	 * Function to bypass Login
	 * WARNING!
	 * To be used only with the excibition mode
	 * */
	public static function loginGuest(){
		if(!defined('EXCIBITION_MODE') || EXCIBITION_MODE != true)
			die("loginGuest called even though we're not in excibition mode, this is most likely a bug please report it");
		self::init(7200);
		//setup session vars
		$_SESSION['hackademic_user'] = 'Guest';
		$_SESSION['hackademic_user_type'] = 0;
		$_SESSION['hackademic_path'] = SOURCE_ROOT_PATH;
		
	}
	public static function isLoggedIn() {
		if (isset($_SESSION['hackademic_user'])) {
			return true;
		} else {
			return false;
		}
	}
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
	public static function completeLogin($owner) {
		User::updateLastVisit($owner->username);
		self::init(SESS_EXP_INACTIVE);
		//setup session vars
		$_SESSION['hackademic_user'] = $owner->username;
		$_SESSION['hackademic_user_id'] = $owner->id;
		$_SESSION['hackademic_user_type'] = $owner->type;
		$_SESSION['hackademic_path'] = SOURCE_ROOT_PATH;
		//error_log("HACKADEMIC:SESSION: path".$_SESSION['hackademic_path'], 0);
		//session_write_close();
	}
	/**
	 * Check password
	 * @param str $pwd Password
	 * @param str $result Result
	 * @return bool Whether or submitted password matches check
	 */
	public function pwdCheck($pwd, $result) {
		$isGood = Utils::check($pwd, $result);
		if ($isGood) {
			return true;

		} else {
			return false;
		}
	}
	/**
	 * @return str Currently logged-in hackademic username
	 */
	public static function getLoggedInUser() {
		if (self::isLoggedIn()) {
			return $_SESSION['hackademic_user'];
		} else {
			return null;
		}
	}
	public static function getLoggedInUserId() {
		if (self::isLoggedIn()) {
			return $_SESSION['hackademic_user_id'];
		} else {
			return null;
		}
	}
	public static function logout() {
		$_SESSION = array();
		setcookie (session_id(), "", time() - 3600);
		session_destroy();
		session_unset();
		session_write_close();
	}
	/*****************************
	 * "security"-ish functions" *
	 * **************************
	 */
	public static function init( $limit = 0,
								 $path = SITE_ROOT_PATH, $domain = null,
								 $secure = null){
			Global $ESAPI_utils;
			// Set the cookie name
			session_name(SESS_NAME);
			// Set SSL level
			$https = isset($secure) ? $secure : isset($_SERVER['HTTPS']);
			// Set session cookie options
			session_set_cookie_params($limit, $path, $domain, $https, true);

			/*if there already exists a valid logged in user session
			 * then we are here by mistake so just log it and regenerate
			 *  the session id
			 */
			if(isset($_SESSION['hackademic_user'])){
				if(self::isValid()){
					self::regenerateSession();
					error_log("HACKADEMIC:: Session:nit called with already existing and valid session
								regenerating session", 0);
				}else{//the function was called on an invalid session
					self::logout();
					/*TODO throw (security?) exception*/
					return;
				}
			}elseif(isset($_SESSION['hackademic_guest'])){
				//if there is a guest session destroy it and login
				self::logout();
				//error_log("HACKADEMIC:: Going from guest to user", 0);
				//error_log("HACKADEMIC:: Starting new session", 0);

				if(!isset($ESAPI_utils)){
					error_log("HACKADEMIC:: Esapi not inited in session start", 0);
					$ESAPI_utils = new Esapi_Utils();
				}
				session_id($ESAPI_utils->getHttpUtilities()->getCSRFToken());
				session_start();
				//error_log(session_id(),0);
				$_SESSION['TOKEN'] = $ESAPI_utils->getHttpUtilities()->getCSRFToken();
				$_SESSION['LAST_ACCESS'] = time();
				$_SESSION['IPaddress'] = $_SERVER['REMOTE_ADDR'];
				$_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
				$_SESSION['created'] = time();
			}
	}
	public static function start($limit = SESS_EXP_INACTIVE,
								 $path = SITE_ROOT_PATH, $domain = null,
								 $secure = null){
		Global $ESAPI_utils;

		// Set the cookie name
		session_name(SESS_NAME);
		// Set SSL level
		$https = isset($secure) ? $secure : isset($_SERVER['HTTPS']);
		// Set session cookie options
		session_set_cookie_params($limit, $path, $domain, $https, true);

		/*If function was called after a session_start then we have a bug*/
		if(isset($_SESSION) &&
		  (isset($_SESSION['hackademic_user']) || isset($_SESSION['hackademic_guest']))){
			error_log("HACKADEMIC:: Regenerating session id possible bug detected", 0);
			self::regenerateSession();
		}else{
			session_start();

			/*If this is a guest session (init hasn't been called first)*/
			if(!self::isLoggedIn() && !isset($_SESSION['hackademic_guest'])){
				$_SESSION['hackademic_guest'] = 'guest';
			}
			// Reset the expiration time upon page load
			if (isset($_COOKIE[SESS_NAME])){
				setcookie(SESS_NAME, session_id(), time() + $limit, $path);
			}
		}
		//currently we are only checking the session for logged in users
		//since the guest user can't do anything in the site
		if(self::isLoggedIn()){
			// Make sure the session hasn't expired and that it is legit,
			// otherwise destroy it
			if(!self::isValid($_SESSION['TOKEN'])){
				error_log("HACKADEMIC:: Invalid Session in Session::start", 0);
				self::logout();
			}
		}
	}
	/*
	 * Session validation
	 * Checks:  Absolute expiration
	 *			Inactive expiration
	 * 			Ip addr
	 * 			User agent
	 * 			Token
	 * Also there is a chance to change the session id on any req
	 */
	public static function isValid($token = null){

		//return true;

		if( isset($_SESSION['OBSOLETE']) && (!isset($_SESSION['EXPIRES']) || !isset($_SESSION['LAST_ACCESS'])) ){
			error_log("HACKADEMIC:: Session validation: OBSOLETE session detected", 0);
			return false;
		}

		if(isset($_SESSION['EXPIRES']) && $_SESSION['EXPIRES'] < time()){
			error_log("HACKADEMIC:: Session validation: EXPIRED session detected", 0);
			return false;
		}

		if(isset($_SESSION['LAST_ACCESS']) && $_SESSION['LAST_ACCESS'] + SESS_EXP_INACTIVE < time()){
			//error_log("HACKADEMIC:: Session validation: INACTIVE session detected", 0);
			return false;
		}
		if(isset($_SESSION['created']) && $_SESSION['created'] + SESS_EXP_ABS < time()){
			//error_log("HACKADEMIC:: Session validation: ABSOLUTE EXPIRED session detected", 0);
			return false;
		}
		if(!isset($_SESSION['IPaddress']) || !isset($_SESSION['userAgent'])){
			error_log("HACKADEMIC:: Session validation: WRONG INFO", 0);
			return false;
		}

		if ($_SESSION['IPaddress'] != $_SERVER['REMOTE_ADDR']){
			error_log("HACKADEMIC:: Session validation: WRONG IPADDR", 0);
			return false;}

		if( $_SESSION['userAgent'] != $_SERVER['HTTP_USER_AGENT']){
			error_log("HACKADEMIC:: Session validation: WRONG USER AGENT", 0);
			return false;}

		/*if(!isset($_SESSION['TOKEN'])){
			error_log("HACKADEMIC:: Session validation: NO TOKEN", 0);
			return false;}

		if(isset($_SESSION['TOKEN']) && $_SESSION['TOKEN'] != $token){
			error_log("HACKADEMIC:: Session validation: WRONG TOKEN", 0);
			return false;}
		*/
		// Give a 5% chance of the session id changing on any request
		if(rand(1, 100) <= 5){
			self::regenerateSession();
		}

		$_SESSION['LAST_ACCESS'] = time();

		return true;
	}
	/* Regenerate id in case of expiration
	 * we get into the trouble of obsoleting the current session instead
	 *  of destroying right away to give time to the ajax plugins to update
	 */
	static function regenerateSession(){
		// If this session is obsolete it means there already is a new id
		if(isset($_SESSION['OBSOLETE']) && $_SESSION['OBSOLETE'] == true){
			error_log("HACKADEMIC:: REGENERATE SESSION obsolete", 0);
			return;}

		// Set current session to expire in 10 seconds
		$_SESSION['OBSOLETE'] = true;
		$_SESSION['EXPIRES'] = time() + 10;

		// Create new session without destroying the old one
		session_regenerate_id(false);

		// Grab current session ID and close both sessions to allow other scripts to use them
		$newSession = session_id();
		session_write_close();

		// Set session ID to the new one, and start it back up again
		session_id($newSession);
		session_start();

		// Now we unset the obsolete and expiration values for the session we want to keep
		unset($_SESSION['OBSOLETE']);
		unset($_SESSION['EXPIRES']);
	}


}
