<?php
/**
 *
 * Hackademic-CMS/controller/class.ReadArticleController.php
 *
 * Hackademic Frontend Read Article Controller
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
require_once(HACKADEMIC_PATH."/model/common/class.ChallengeAttempts.php");
require_once(HACKADEMIC_PATH."/model/common/class.User.php");
require_once(HACKADEMIC_PATH."/model/common/class.UserScore.php");
require_once(HACKADEMIC_PATH."/controller/class.HackademicController.php");
require_once(HACKADEMIC_PATH."/admin/model/class.ClassMemberships.php");
require_once(HACKADEMIC_PATH."/admin/model/class.Classes.php");

class RankingsController extends HackademicController {

    private static $action_type = 'rankings';
   
    static  function sort_count($rankA, $rankB) {
	if ($rankA['score'] == $rankB['score']) {
			return 0;
	}
        return ($rankA['score'] < $rankB['score']) ? 1 : -1;
    }
   
    public function go() {
        $this->setViewTemplate("rankings.tpl");
        if (self::isLoggedIn()) {
            $username = self::getLoggedInUser();
            if (Session::isAdmin() || Session::isTeacher()) {
                $classes = Classes::getAllClasses();
            } else {
                $user = User::findByUserName($username);
                $classes = ClassMemberships::getMembershipsOfUserObjects($user->id);
		$show_global_rankings = new Classes();
		$show_global_rankings->id = "";
		$show_global_rankings->name = "Show Universal Rankings";
		array_unshift($classes, $show_global_rankings);
            }
            $this->addToView('classes', $classes);
        }
        if (!isset($_GET["class"]) || $_GET["class"]=="") {
            $rankings = ChallengeAttempts::getUniversalRankings();
            $class_id = GLOBAL_CLASS_ID;
        } else {
            $class_id = $_GET["class"];
            $class = Classes::getClass($class_id);
            if (!$class) {
                $this->addErrorMessage("Not a valid class");
                return $this->generateView(self::$action_type);
            } else {
                $rankings = ChallengeAttempts::getClasswiseRankings($class_id);
            }
        }
       usort($rankings, array("RankingsController", "sort_count"));
	$this->addToView('rankings', $rankings);
        $this->addSuccessMessage("Showing Active Users Only");
	return $this->generateView(self::$action_type);
    }
}
