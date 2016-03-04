<?php
/**
 *
 * Hackademic-CMS/model/common/class.Utils.php
 *
 * Hackademic Utils Class
 * Generic, common and utility methods
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


class Utils {

	/**
	 * Define Constants function. These constants are used to locate files on the server
	 */
	public static function defineConstants() {
		if (!defined('HACKADEMIC_PATH')) {
			define('HACKADEMIC_PATH', str_replace("\\",'/', dirname(dirname(dirname(__FILE__)))).'/');
			define('GLOBAL_CLASS_ID',1);
			define('DEFAULT_RULES_ID',1);
			define('NO_RESULTS',false);
			define('MICROSECS_IN_MINUTE',60);
		}
    if(!defined('HACKADEMIC_PLUGIN_PATH')) {
      define('HACKADEMIC_PLUGIN_PATH', HACKADEMIC_PATH . 'user/plugins/');
    }
    if(!defined('HACKADEMIC_THEME_PATH')) {
      define('HACKADEMIC_THEME_PATH', HACKADEMIC_PATH . 'user/themes/');
    }
	}

	public function validateEmail($email = '') {
		$hostname = '(?:[a-z0-9][-a-z0-9]*\.)*(?:[a-z0-9][-a-z0-9]{0,62})\.(?:(?:[a-z]{2}\.)?[a-z]{2,4}|museum|travel)';
		$pattern = '/^[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@' . $hostname . '$/i';
		return preg_match($pattern, $email);
	}

	public static function hash($password){
		$hash = password_hash($password);
		if (FALSE === $hash)){
			throw new Exception('Password could not be hashed');
			return false;
		}
		return $hash;
	}

	public static function check($input, $hash){
		return password_verify($input,$hash);
	}

	public static function sanitizeInput($input) {
		$input = str_replace( "\0", "", $input);
		$input = htmlspecialchars($input);
		return $input;
	}
}
