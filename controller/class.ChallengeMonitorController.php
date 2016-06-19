<?php

require_once HACKADEMIC_PATH."model/common/class.Challenge.php";
require_once HACKADEMIC_PATH."model/common/class.User.php";
require_once HACKADEMIC_PATH."model/common/class.Session.php";
require_once HACKADEMIC_PATH."model/common/class.ChallengeAttempts.php";
require_once HACKADEMIC_PATH."admin/model/class.ClassMemberships.php";
require_once HACKADEMIC_PATH."admin/model/class.ClassChallenges.php";
require_once HACKADEMIC_PATH."model/common/class.UserHasChallengeToken.php";
require_once HACKADEMIC_PATH."controller/class.HackademicController.php";
require_once HACKADEMIC_PATH."model/common/class.ScoringRule.php";
require_once HACKADEMIC_PATH."model/common/class.UserScore.php";

if (!defined('EXPERIMENTATION_BONUS_ID')) {
    define('EXPERIMENTATION_BONUS_ID', "experimentation_bonus");
    define('TIME_LIMIT_PENALTY_ID', "time_limit_penalty");
    define('RPS_PENALTY_ID', "request_per_second_penalty");
    define('UA_PENALTY_ID', "banned_user_agent_penalty");
    define('MULT_SOL_BONUS_ID', "multiple_solution_bonus");
    define('TOTAL_ATTEMPT_PENALTY_ID', "total_attempt_penalty");
    define('FTS_PENALTY_ID', "first_try_penalty");

    define("CHALLENGE_INIT", 2);
    define("CHALLENGE_SUCCESS", 1);
    define("CHALLENGE_FAILURE", 0);
}
class ChallengeMonitorController
{
    public function go()
    {
        // Check Permissions
    }
    public function getPkgName()
    {
        $url = $_SERVER['REQUEST_URI'];
        $url_components = explode("/", $url);
        $count_url_components = count($url_components);
        for ($i=0; $url_components[$i] != "challenges"; $i++) {
        }
        $pkg_name = $url_components[$i+1];
        return $pkg_name;
    }
    public function start($status, $user_id = null, $chid = null, $class_id = null, $token = null)
    {
        //		var_dump($_SESSION);
        if (!isset($_SESSION)) {
            session_start();
        }

        if ($status == CHALLENGE_INIT && !isset($_SESSION['init'])) {
            $_SESSION['chid'] = $chid;
            $_SESSION['token'] = $token;
            $_SESSION['user_id'] = $user_id;
            $_SESSION['pkg_name'] = $this->getPkgName();
            $_SESSION['class_id'] = $class_id;
            $this->calcScore($status, $user_id, $chid, $class_id);
            $_SESSION['init'] = true;
            //var_dump($_SESSION);
            return;
        }
        $pkg_name = $this->getPkgName();
        //echo"<p>";var_dump($token);echo "</p>";
        //echo"<p>";var_dump($_SESSION['token']);echo "</p>";
        if (!isset($_SESSION['chid'])) {
            $_SESSION['chid'] = $chid;
        }
        if (!isset($_SESSION['token'])) {
            $_SESSION['token'] = $token;
        }
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['user_id'] = $user_id;
        }
        if (!isset($_SESSION['pkg_name'])) {
            $_SESSION['pkg_name'] = $pkg_name;
        }
        if (!isset($_SESSION['class_id'])) {
            $_SESSION['class_id'] = $class_id;
        }

        self::_checkValues($user_id, $chid, $class_id, $token);
    }

    private function _invalidChallenge()
    {
        $_SESION = array();
        unset($_SESSION);
        header("Location: ".SITE_ROOT_PATH);
        die();
    }
    private function _checkValues($user_id = null, $chid = null, $class_id = null, $token = null)
    {

        //TODO full of ugly hacks needs refactoring start by putting an else with
        //redirect after the if $pair

        if ($user_id === null) {
            $user_id = $_SESSION['user_id'];
        }
        if ($chid === null) {
            $chid = $_SESSION['chid'];
        }
        if ($class_id === null) {
            $class_id = $_SESSION['class_id'];
        }
        if ($token === null) {
            $token = $_SESSION['token'];
        }

        $pair = UserHasChallengeToken::find($user_id, $chid, $class_id);
        $pkg_name = $this->getPkgName();

        /**
         * If token is the one in the session then we have to check the
         * rest of the values
         */
        if ($_SESSION['token'] == $token && $token != null) {

            // User changed challenge
            if (($pkg_name != $_SESSION['pkg_name'] && $pkg_name != null)
                || ($_SESSION['chid'] != $chid && $chid != null)
            ) {
                if (!$pair) {
                    $this->_invalidChallenge();
             } else {
                    $_SESSION['pkg_name'] = $pkg_name;
                    $_SESSION['chid'] = $chid;
             }
            }
            //User is doing the same challenge for a different class
            if ($_SESSION['class_id'] != $class_id && $class_id != null) {
                if (!$pair) {
                    $this->_invalidChallenge();
                } else {
                    $_SESSION['class_id'] = $class_id;
                }
            }

            // if the user_id changed but the token for the user/class/challenge is correct update
            if ($_SESSION['user_id'] != $user_id && $user_id != null) {
                if (!$pair) {
                    $this->_invalidChallenge();
                } else {
                       $_SESSION['user_id'] = $user_id;
                }
            }
        } else {
            if ($pair && $pair->token == $token) {
                $_SESSION['token'] = $token;
            } else {
                error_log("Token provided: ". $token."</br>Token on session ".$_SESSION['token']. "</br>Token for user/class");
                header("Location:".SITE_ROOT_PATH); die();
            }
        }
    }
    public function update($status, $request='')
    {
        if (!empty($request) ) {
            $user_id = $request['user_id'];
            $chid = $request['id'];
            $class_id = $request['class_id'];
            $token = $request['token'];
            $this->start($status, $user_id, $chid, $class_id, $token);
        }
      error_log("sTATUS in update is ".$status);
       /*
        * if status == init we only need to update the SESSION var which we do in start
        */
        if ($status == CHALLENGE_INIT) {
            return;
        }
        if ($user_id == null) {
            $user_id = $_SESSION['user_id'];
        }
        if ($chid == null) {
            $chid = $_SESSION['chid'];
        }
        if ($token == null) {
            $token = $_SESSION['token'];
        }
        if ($class_id == null) {
            $class_id = $_SESSION['class_id'];
        }
        $this->calcScore($status, $user_id, $chid, $class_id);

        $username = $user_id;
        $url = $_SERVER['REQUEST_URI'];
        $url_components = explode("/", $url);
        $count_url_components = count($url_components);
        for ($i=0; $url_components[$i] != "challenges"; $i++) {
        }
        $pkg_name = $url_components[$i+1];
        $user = User::findByUserName($username);
        $challenge = Challenge::getChallengeByPkgName($pkg_name);
        if ($user) {
            $user_id = $user->id;
        }
         $challenge_id = $challenge->id;
        if (!ChallengeAttempts::isChallengeCleared($user_id, $challenge_id)) {
            ChallengeAttempts::addChallengeAttempt($user_id, $challenge_id, $class_id, $status);
        }
    }
    /**
     * Called for unsuccesful attempt, updates the current score for the user
     * Called on success calculates the total score for the user
     */
    public function calcScore($status, $user_id, $challenge_id, $class_id)
    {
        if (!isset($_SESSION['rules']) || !is_array($_SESSION['rules'])|| $_SESSION['rules'] == "") {
            $rule = ScoringRule::getScoringRuleByChallengeClassId($challenge_id, $class_id);

            // if challenge has not scoring rules load up the default ones
            if ($rule === false) {
                $rule = ScoringRule::getScoringRule(DEFAULT_RULES_ID);
            }
            /* Add the rules to the session */
            $_SESSION['rules'] =  (array)$rule;
        }
        /* load the rules and the current score*/
        $attempt_cap = $_SESSION['rules']['attempt_cap'];
        $attempt_cap_penalty = $_SESSION['rules']['attempt_cap_penalty'];

        $t_limit = $_SESSION['rules']['time_between_first_and_last_attempt'];
        $reset_time = $_SESSION['rules']['time_reset_limit_seconds'];
        $time_penalty = $_SESSION['rules']['time_penalty'];

        $rps_limit = $_SESSION['rules']['request_frequency_per_minute'];
        $rps_penalty = $_SESSION['rules']['request_frequency_penalty'];

        $exp_bonus = $_SESSION['rules']['experimentation_bonus'];
        $mult_sol_bonus = $_SESSION['rules']['multiple_solution_bonus'];

        $banned_user_agents = $_SESSION['rules']['banned_user_agents'];
        $banned_ua_penalty =  $_SESSION['rules']['banned_user_agents_penalty'];

        $base_score = $_SESSION['rules']['base_score'];

        $first_try_limit = $_SESSION['rules']['first_try_solves'];
        $fts_penalty = $_SESSION['rules']['penalty_for_many_first_try_solves'];

        $current_score = UserScore::getScoresForUserClassChallenge($user_id, $class_id, $challenge_id);

        if ($current_score === false && $status != CHALLENGE_INIT) {
            self::calcScore(CHALLENGE_INIT, $user_id, $challenge_id, $class_id);
            $current_score = UserScore::getScoresForUserClassChallenge($user_id, $class_id, $challenge_id);
            $_SESSION['current_score'] = (array)$current_score;
        }
        if ($status == CHALLENGE_INIT) {
            foreach ($_SESSION['rules'] as $key=>$value) {
                unset($_SESSION['rules'][$key]);
            }
            unset($_SESSION['rules']);

            if ($current_score === false) {
                $current_score = new UserScore();
                $current_score->user_id = $user_id;
                $current_score->class_id = $class_id;
                $current_score->challenge_id = $challenge_id;
                $current_score->points = 0;
                $current_score->penalties_bonuses = '';
                UserScore::addUserScore($current_score);
                $current_score = UserScore::getScoresForUserClassChallenge($user_id, $class_id, $challenge_id);
            }
            $_SESSION['f_atempt'] = date("Y-m-d H:i:s");
            $_SESSION['last_attempt'] = date("Y-m-d H:i:s");
            $_SESSION['total_attempt_count'] = 0;

            $_SESSION['rps_attempt_count'] = 1;
            $_SESSION['rps_min_start'] = microtime(true);
            $_SESSION['last_attempt_microsecs'] = microtime(true);

            $_SESSION['ua'] = $_SERVER['HTTP_USER_AGENT'];

            return;

        } elseif ($status == CHALLENGE_FAILURE) {
            if (ChallengeAttempts::isChallengeCleared($user_id, $challenge_id, $class_id)) {
                if (strpos($current_score->penalties_bonuses, EXPERIMENTATION_BONUS_ID) === false && $exp_bonus > 0) {
                    // apply experimentation bonus
                    $current_score->points += $exp_bonus;
                    $current_score->penalties_bonuses .= EXPERIMENTATION_BONUS_ID;
                    $current_score->penalties_bonuses .= ",";
                }
                UserScore::update_user_score($current_score);
                return;
            }
            if ($_SESSION['total_attempt_count'] > $attempt_cap) {
                // apply total attempt penalty
                if (strpos($current_score->penalties_bonuses, TOTAL_ATTEMPT_PENALTY_ID) === false && $attempt_cap_penalty > 0) {
                    $current_score->points -= $attempt_cap_penalty;
                    $current_score->penalties_bonuses .= TOTAL_ATTEMPT_PENALTY_ID;
                    $current_score->penalties_bonuses .= ",";
                }
            }
            $_SESSION['total_attempt_count']++;

            $t_since_first = strtotime(date("Y-m-d H:i:s")) - strtotime($_SESSION['f_atempt']);
            if ($t_since_first >= $reset_time) {
                $t_since_first = 0;
            }
            if ($t_since_first >= $t_limit) {
                // apply total time penalty
                if (strpos($current_score->penalties_bonuses, TIME_LIMIT_PENALTY_ID) === false && $time_penalty > 0) {
                    $current_score->points -= $time_penalty;
                    $current_score->penalties_bonuses .= TIME_LIMIT_PENALTY_ID;
                    $current_score->penalties_bonuses .= ",";
                }
            }
            $diff = microtime(true) - $_SESSION['rps_min_start'];
            $_SESSION['last_attempt_microsecs'] = microtime(true);
            if ($diff >= MICROSECS_IN_MINUTE) {
                if ($_SESSION['rps_attempt_count'] >= $rps_limit) {
                    /* apply requests per minute penalty*/
                    if (strpos($current_score->penalties_bonuses, RPS_PENALTY_ID) === false && $rps_penalty > 0) {
                        $current_score->points -= $rps_penalty;
                        $current_score->penalties_bonuses .= RPS_PENALTY_ID;
                        $current_score->penalties_bonuses .= ",";
                    }
                }
                $_SESSION['rps_min_start'] = microtime(true);
                $_SESSION['rps_attempt_count'] = 0;
            } else {
                $_SESSION['rps_attempt_count']++;
            }
            $ua_check = strpos($banned_user_agents, $_SERVER['HTTP_USER_AGENT']);
            if ($ua_check != false) {
                // apply user agent penalty
                if (strpos($current_score->penalties_bonuses, UA_PENALTY_ID) === false && $banned_ua_penalty > 0) {
                    $current_score->points -= $banned_ua_penalty;
                    $current_score->penalties_bonuses .= UA_PENALTY_ID;
                    $current_score->penalties_bonuses .= ",";
                }

            }
        } elseif ($status == CHALLENGE_SUCCESS) {
            if (ChallengeAttempts::isChallengeCleared($user_id, $challenge_id, $class_id)) {
                // apply multiple solutions bonus
                if (strpos($current_score->penalties_bonuses, MULT_SOL_BONUS_ID) === false && $mult_sol_bonus > 0) {
                    $current_score->points += $mult_sol_bonus;
                    $current_score->penalties_bonuses .= MULT_SOL_BONUS_ID;
                    $current_score->penalties_bonuses .= ",";
                }
            } else {
                $current_score->points += $base_score;
                // 	get the tries from the database
                $first = ChallengeAttempts::getUserFirstChallengeAttempt($user_id, $challenge_id, $class_id);
                $last_db = ChallengeAttempts::getUserLastChallengeAttempt($user_id, $challenge_id, $class_id);
                $last = date("Y-m-d H:i:s");
                $total_count = ChallengeAttempts::getUserTriesForChallenge($user_id, $challenge_id, $class_id);
                false === $total_count?$total_count = 0: $total_count;
                if ($last_db !=false) {
                    $t_since_first = strtotime(date("Y-m-d H:i:s")) - strtotime($last_db->time);
                } else {
                    $t_since_first = 0;
                }

                if ($t_since_first >= $t_limit) {
                    /* apply time limit penalty */
                    if (strpos($current_score->penalties_bonuses, TIME_LIMIT_PENALTY_ID) === false && $time_penalty > 0) {
                        $current_score->points -= $time_penalty;
                        $current_score->penalties_bonuses .= TIME_LIMIT_PENALTY_ID;
                        $current_score->penalties_bonuses .= ",";
                    }
                }
                $diff = microtime(true) - $_SESSION['rps_min_start'];
                if ($diff >= MICROSECS_IN_MINUTE) {
                    if ($_SESSION['rps_attempt_count'] >= $rps_limit) {
                        /* apply requests per second penalty*/
                        if (strpos($current_score->penalties_bonuses, RPS_PENALTY_ID) === false && $rps_penalty > 0) {
                            $current_score->points -= $rps_penalty;
                            $current_score->penalties_bonuses .= RPS_PENALTY_ID;
                            $current_score->penalties_bonuses .= ",";
                        }
                    }
                    $_SESSION['rps_min_start'] = microtime(true);
                    $_SESSION['rps_attempt_count'] = 0;
                } else {
                    /**
                     * If user solved it in under a minute
                     * (or not a full minute has  passed since last reset)
                     */
                    $t_since_last_micro = microtime(true) - $_SESSION['last_attempt_microsecs'];
                    if ($_SESSION['rps_attempt_count'] >= $rps_limit) {
                        /* apply requests per second penalty*/
                        if (strpos($current_score->penalties_bonuses, RPS_PENALTY_ID) === false && $rps_penalty > 0) {
                            $current_score->points -= $rps_penalty;
                            $current_score->penalties_bonuses .= RPS_PENALTY_ID;
                            $current_score->penalties_bonuses .= ",";
                        }
                    }
                }
                if (1 + $total_count >= $attempt_cap) {
                    /* apply total attempt penalty*/
                    if (strpos($current_score->penalties_bonuses, TOTAL_ATTEMPT_PENALTY_ID) === false && $attempt_cap > 0) {
                        $current_score->points -= $attempt_cap_penalty;
                        $current_score->penalties_bonuses .= TOTAL_ATTEMPT_PENALTY_ID;
                        $current_score->penalties_bonuses .= ",";
                    }
                }
                $count_first_try = ChallengeAttempts::getCountOfFirstTrySolves($user_id, $class_id);
                if ($_SESSION['total_attempt_count'] == 0) {
                    $count_first_try++;
                }
                if ($first_try_limit != 0 && $count_first_try >= $first_try_limit) {
                    /* apply cheater penalty */
                    if (strpos($current_score->penalties_bonuses, FTS_PENALTY_ID) === false && $fts_penalty > 0) {
                        $current_score->points -= $fts_penalty;
                        $current_score->penalties_bonuses .= FTS_PENALTY_ID;
                        $current_score->penalties_bonuses .= ",";
                    }
                }
            }
        }
        UserScore::update_user_score($current_score);
    }
}
