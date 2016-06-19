<?php
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
		$hash = password_hash($password, PASSWORD_DEFAULT);
		if (FALSE === $hash || NULL === $hash){
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
