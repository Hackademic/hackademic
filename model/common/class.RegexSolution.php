<?php
/**
 *
 * Hackademic-CMS/model/common/class.RegexSolution.php
 *
 * Hackademic Challenge Regex Solution
 * Class for building regular expressions to validate challenges' solutions
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

class RegexSolution {
	const PHP_BEGIN = '<\?((php|=) )? ?';
	const PHP_END = ' ?;? ?\?>';
	const JS_BEGIN = '< ?script( type="text\/javascript")? ?> ?';
	const JS_END = ' ?;? ?< ?\/ ?script ?>';
	private $regex;
	
	/**
	 * Constructor
	 * Replaces all double quotes with single quotes.
	 * @param $regex The regular expression to validate the challenge's answer.
	 */
	public function RegexSolution($regex) {
		$this->regex = '/'.$regex.'/';
		$this->regex = str_replace('"', '\'', $this->regex);
	}

	/**
	 * Matches the submitted solution against the regular expression.
	 * @param $answer The submitted solution.
	 * @return True if the answer matches the solution's regex.
	 */
	public function match($answer) {
		$answer = preg_replace('/\s+/', ' ', $answer);
		$answer = str_replace('"', '\'', $answer);
		if (preg_match($this->regex, $answer)) {
			return true;
		} else {
			return false;
		}
	}
}
