<?php
/**
 *
 * Hackademic-CMS/controller/class.ChallengeMonitorController.php
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
require_once(HACKADEMIC_PATH."model/common/class.Challenge.php");
require_once(HACKADEMIC_PATH."model/common/class.User.php");
require_once(HACKADEMIC_PATH."model/common/class.Session.php");
require_once(HACKADEMIC_PATH."model/common/class.ChallengeAttempts.php");
require_once(HACKADEMIC_PATH."admin/model/class.ClassMemberships.php");
require_once(HACKADEMIC_PATH."admin/model/class.ClassChallenges.php");
require_once(HACKADEMIC_PATH."model/common/class.UserHasChallengeToken.php");
require_once(HACKADEMIC_PATH."controller/class.HackademicController.php");

class ChallengeMonitorController {

    public function go() {
        // Check Permissions
    }

    public function get_pkg_name(){
		$url = $_SERVER['REQUEST_URI'];
        $url_components = explode("/", $url);
        $count_url_components = count($url_components);
        for ($i=0; $url_components[$i] != "challenges"; $i++);
			$pkg_name = $url_components[$i+1];
		return $pkg_name;
	}
    public function start($userid=null, $chid=null, $token=null,$status = 'CHECK'){
		if(!isset($_SESSION))
			session_start();

		if($status == CHALLENGE_INIT && !isset($_SESSION['init'])){
			$_SESSION['chid'] = $chid;
			$_SESSION['token'] = $token;
			$_SESSION['userid'] = $userid;
			$_SESSION['pkg_name'] = $this->get_pkg_name();
			//var_dump($_SESSION);
			return;
		}
		$pkg_name = $this->get_pkg_name();
		//echo"<p>";var_dump($token);echo "</p>";
		//echo"<p>";var_dump($_SESSION['token']);echo "</p>";
		if(!isset($_SESSION['chid']))
			$_SESSION['chid'] = $chid;
		if(!isset($_SESSION['token']))
			$_SESSION['token'] = $token;
		if(!isset($_SESSION['userid']))
			$_SESSION['userid'] = $userid;
		if(!isset($_SESSION['pkg_name']))
			$_SESSION['pkg_name'] = $pkg_name;

		$pair = UserHasChallengeToken::findByPair($userid,$chid,$token);

		/*If token is the one in the session then challenge must be the same*/
		if($_SESSION['token'] == $token)
		if($pkg_name != $_SESSION['pkg_name']  || $_SESSION['chid'] != $chid){
			error_log("HACKADEMIC::ChallengeMonitorController::RIGHT token WRONG CHALLENGE it's ".$pkg_name.' it should be '.$_SESSION['pkg_name']);
			header("Location: ".SITE_ROOT_PATH);
			die();
		}
		/* If token changed AND the challenge changed AND its a valid token
		 * for that challenge then we are in a new challenge
		 */
		if($_SESSION['token'] != $token && $token!=null)
			if($pkg_name != $_SESSION['pkg_name']  || $_SESSION['chid'] != $chid || $_SESSION['userid'] != $userid){
				if($pair->token == $token){
					$_SESSION['chid'] = $chid;
					$_SESSION['token'] = $token;
					$_SESSION['pkg_name'] = $pkg_name;
					$_SESSION['userid'] = $userid;
				}
			}else{
				//var_dump($_SESSION);//die();
				error_log("HACKADEMIC::ChallengeMonitorController::Hijacking attempt? ".$_SESSION['pkg_name']);
				header("Location: ".SITE_ROOT_PATH);
				die();
			}

		/*echo"<p>";var_dump($pair);echo "</p>";
		echo"<p>";var_dump($token);echo "</p>";
		echo"<p>";var_dump($_SESSION['token']);echo "</p>";
		*/
		if($pair && $pair->token != $token){
			error_log("HACKADEMIC::ChallengeMonitorController::pair->token != $token".$pair->token);
			header("Location: ".SITE_ROOT_PATH);
			die();

		}
	}
    public function update($status,$userid = null ,$chid = null ,$token = null) {

		$this->start($userid,$chid,$token,$status);
		/*IF status == init we only need to update the SESSION var*/
		if($status == CHALLENGE_INIT)
		return;

		if($userid == null)
			$userid = $_SESSION['userid'];
		if($chid == null)
			$chid = $_SESSION['chid'];
		if($token == null)
			$token = $_SESSION['token'];

        $username = $userid;
        $url = $_SERVER['REQUEST_URI'];
        $url_components = explode("/", $url);
        $count_url_components = count($url_components);
        for ($i=0; $url_components[$i] != "challenges"; $i++);
		$pkg_name = $url_components[$i+1];
        $user = User::findByUserName($username);
        $challenge = Challenge::getChallengeByPkgName($pkg_name);
        if($user)
           $user_id = $user->id;
         $challenge_id = $challenge->id;
         if (!ChallengeAttempts::isChallengeCleared($user_id, $challenge_id)) {
			ChallengeAttempts::addChallengeAttempt($user_id, $challenge_id, $status);
          }
   }


}
