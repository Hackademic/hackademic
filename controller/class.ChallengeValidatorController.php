<?php
/**
 * Hackademic-CMS/controller/class.ChallengeValidatorController.php
 *
 * Hackademic Challenge Validator Controller
 * Class for validating challenges' answers
 *
 * Copyright (c) 2012 OWASP
 *
 * LICENSE:
 *
 * This file is part of Hackademic CMS
 * (https://www.owasp.org/index.php/OWASP_Hackademic_Challenges_Project).
 *
 * Hackademic CMS is free software: you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 2 of the License, or (at your option) any later
 * version.
 *
 * Hackademic CMS is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
 * PARTICULAR PURPOSE.  See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * Hackademic CMS.  If not, see <http://www.gnu.org/licenses/>.
 *
 * PHP Version 5.
 *
 * @author    Paul Chaignon <paul.chaignon@gmail.com>
 * @copyright 2012 OWASP
 * @license   GNU General Public License http://www.gnu.org/licenses/gpl.html
 */
require_once HACKADEMIC_PATH."controller/class.ChallengeMonitorController.php";
require_once HACKADEMIC_PATH."model/common/class.RegexSolution.php";

class ChallengeValidatorController
{
    private $_monitor;
    private $_solution;

    /**
     * Constructor
     * @param $_solution The solution of the challenge.
     * The solution can be an integer, a string or a regex solution.
     * @see class.RegexSolution.php
     */
    public function ChallengeValidatorController($_solution)
    {
        $this->_solution = $_solution;
        $this->_monitor = new ChallengeMonitorController();
        $this->_monitor->go();
    }

    /**
     * Initialize the challenge's monitor.
     */
    public function startChallenge()
    {
        error_log("initing challenge ");
        $this->_monitor->update(CHALLENGE_INIT, $_GET);
    }

    /**
     * Validates a submitted solution.
     * Updates the monitor state depending on the result.
     * @param $answer The submitted solution.
     * @return True if the submitted solution was correct.
     */
    public function validateSolution($answer)
    {
        $valid = false;
        if ($this->_solution instanceof RegexSolution) {
            $valid = $this->_solution->match($answer);
        } else {
            $valid = $this->_solution == $answer;
        }

        if ($valid) {  error_log("validate sending".CHALLENGE_SUCCESS);
            $this->_monitor->update(CHALLENGE_SUCCESS,$_GET);
        } else {
          error_log("f");
            $this->_monitor->update(CHALLENGE_FAILURE,$_GET);
        }

        return $valid;
    }

    /**
     * Record a failed attempt to solve the challenge in the monitor.
     */
    public function failChallenge()
    {
        $this->_monitor->update(CHALLENGE_FAILURE,$_GET);
    }
}
