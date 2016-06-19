<?php

class Utils {

	public function validateEmail($email = '') {
		$hostname = '(?:[a-z0-9][-a-z0-9]*\.)*(?:[a-z0-9][-a-z0-9]{0,62})\.(?:(?:[a-z]{2}\.)?[a-z]{2,4}|museum|travel)';
		$pattern = '/^[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@' . $hostname . '$/i';
		return preg_match($pattern, $email);
	}

	public static function getPassUtil(){
		return $util = new PasswordHash(8, true);
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
		return password_verify($input, $hash);
	}
}
