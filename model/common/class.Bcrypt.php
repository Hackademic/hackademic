<?php

class Bcrypt
{
  private $_rounds;
  public function __construct($_rounds = 12)
  {
    if (CRYPT_BLOWFISH != 1) {
      throw new Exception("bcrypt not supported in this installation. See http://php.net/crypt");
    }

    $this->_rounds = $_rounds;
  }

  public function hash($input)
  {
    $hash = crypt($input, $this->_getSalt());

    if (strlen($hash) > 13) {
		return $hash;
	}

    return false;
  }

  public function verify($input, $existingHash)
  {
    $hash = crypt($input, $existingHash);

    return $hash === $existingHash;
  }

  private function _getSalt()
  {
    $salt = sprintf('$2a$%02d$', $this->_rounds);

    $bytes = $this->_getRandomBytes(16);

    $salt .= $this->_encodeBytes($bytes);

    return $salt;
  }

  private $_randomState;
  private function _getRandomBytes($count)
  {
    $bytes = '';

    if (function_exists('openssl_random_pseudo_bytes') &&
		(strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN')
	) {
		// OpenSSL slow on Win
      $bytes = openssl_random_pseudo_bytes($count);
    }

    if ($bytes === '' && is_readable('/dev/urandom') &&
       ($hRand = @fopen('/dev/urandom', 'rb')) !== false) {
      $bytes = fread($hRand, $count);
      fclose($hRand);
    }

    if (strlen($bytes) < $count) {
      $bytes = '';

      if ($this->_randomState === null) {
        $this->_randomState = microtime();
        if (function_exists('getmypid')) {
          $this->_randomState .= getmypid();
        }
      }

      for ($i = 0; $i < $count; $i += 16) {
        $this->_randomState = md5(microtime() . $this->_randomState);

        if (PHP_VERSION >= '5') {
          $bytes .= md5($this->_randomState, true);
        } else {
          $bytes .= pack('H*', md5($this->_randomState));
        }
      }

      $bytes = substr($bytes, 0, $count);
    }

    return $bytes;
  }

  private function _encodeBytes($input)
  {
    // The following is code from the PHP Password Hashing Framework
    $itoa64 = './ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    $output = '';
    $i = 0;
    do {
      $c1 = ord($input[$i++]);
      $output .= $itoa64[$c1 >> 2];
      $c1 = ($c1 & 0x03) << 4;
      if ($i >= 16) {
        $output .= $itoa64[$c1];
        break;
      }

      $c2 = ord($input[$i++]);
      $c1 |= $c2 >> 4;
      $output .= $itoa64[$c1];
      $c1 = ($c2 & 0x0f) << 2;

      $c2 = ord($input[$i++]);
      $c1 |= $c2 >> 6;
      $output .= $itoa64[$c1];
      $output .= $itoa64[$c2 & 0x3f];
    } while (1);

    return $output;
  }
}
?>
