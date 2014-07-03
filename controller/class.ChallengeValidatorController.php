<?php
/**
 *
 * Hackademic-CMS/controller/class.ChallengeValidatorController.php
 *
 * Hackademic Challenge Validator Controller
 * Class for validating challenges' answers
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
 * @author Paul Chaignon <paul.chaignon@gmail.com>
 * @license http://www.gnu.org/licenses/gpl.html
 * @copyright 2012 OWASP
 *
 */
require_once(HACKADEMIC_PATH."controller/class.ChallengeMonitorController.php");
require_once(HACKADEMIC_PATH."model/common/class.RegexSolution.php");

class ChallengeValidatorController {
	private $monitor;
	private $solution;

	/**
	 * Constructor
	 * @param $solution The solution of the challenge.
	 * The solution can be an integer, a string or a regex solution.
	 * @see class.RegexSolution.php
	 */
	public function ChallengeValidatorController($solution) {
		$this->solution = $solution;
		$this->monitor = new ChallengeMonitorController();
		$this->monitor->go();
	}

	/**
	 * Initialize the challenge's monitor.
	 */
	public function startChallenge() {
		$this->monitor->update(CHALLENGE_INIT, $_GET);
	}

	/**
	 * Validates a submitted solution.
	 * Updates the monitor state depending on the result.
	 * @param $answer The submitted solution.
	 * @return True if the submitted solution was correct.
	 */
	public function validateSolution($answer) {
		$valid = false;
		if($this->solution instanceof RegexSolution) {
			$valid = $this->solution->match($answer);
		} else {
			$valid = $this->solution == $answer;
		}

		if($valid) {
			$this->monitor->update(CHALLENGE_SUCCESS);
		} else {
			$this->monitor->update(CHALLENGE_FAILURE);
		}

		return $valid;
	}

	/**
	 * Record a failed attempt to solve the challenge in the monitor.
	 */
	public function failChallenge() {
		$this->monitor->update(CHALLENGE_FAILURE);
	}
}
