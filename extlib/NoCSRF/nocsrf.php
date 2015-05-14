<?php
/**
 * NoCSRF, an anti CSRF token generation/checking class.
 *
 * Copyright (c) 2011 Thibaut Despoulain <http://bkcore.com/blog/code/nocsrf-php-class.html>
 * Licensed under the MIT license <http://www.opensource.org/licenses/mit-license.php>
 *
 * @author Thibaut Despoulain <http://bkcore.com>
 * @version 1.0
 */
class NoCSRF
{

    protected static $doOriginCheck = false;

    /**
     * Check CSRF tokens match between session and $origin. 
     * Make sure you generated a token in the form before checking it.
     *
     * @param String $key The session and $origin key where to find the token.
     * @param Mixed $origin The object/associative array to retreive the token data from (usually $_POST).
     * @param Boolean $throwException (Facultative) TRUE to throw exception on check fail, FALSE or default to return false.
     * @param Integer $timespan (Facultative) Makes the token expire after $timespan seconds. (null = never)
	 * @param Boolean $multiple (Facultative) Makes the token reusable and not one-time. (Useful for ajax-heavy requests).
     * 
     * @return Boolean Returns FALSE if a CSRF attack is detected, TRUE otherwise.
     */
    public static function check( $key, $origin, $throwException=false, $timespan=null, $multiple=false )
    {
        if ( !isset( $_SESSION[ 'csrf_' . $key ] ) )
            if($throwException)
                throw new Exception( 'Missing CSRF session token.' );
            else
                return false;
            
        if ( !isset( $origin[ $key ] ) )
            if($throwException)
                throw new Exception( 'Missing CSRF form token.' );
            else
                return false;

        // Get valid token from session
        $hash = $_SESSION[ 'csrf_' . $key ];
		
        // Free up session token for one-time CSRF token usage.
		if(!$multiple)
			$_SESSION[ 'csrf_' . $key ] = null;

        // Origin checks
        if( self::$doOriginCheck && sha1( $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] ) != substr( base64_decode( $hash ), 10, 40 ) )
        {
            if($throwException)
                throw new Exception( 'Form origin does not match token origin.' );
            else
                return false;
        }
        
        // Check if session token matches form token
        if ( $origin[ $key ] != $hash )
            if($throwException)
                throw new Exception( 'Invalid CSRF token.' );
            else
                return false;

        // Check for token expiration
        if ( $timespan != null && is_int( $timespan ) && intval( substr( base64_decode( $hash ), 0, 10 ) ) + $timespan < time() )
            if($throwException)
                throw new Exception( 'CSRF token has expired.' );
            else
                return false;

        return true;
    }

    /**
     * Adds extra useragent and remote_addr checks to CSRF protections.
     */
    public static function enableOriginCheck()
    {
        self::$doOriginCheck = true;
    }

    /**
     * CSRF token generation method. After generating the token, put it inside a hidden form field named $key.
     *
     * @param String $key The session key where the token will be stored. (Will also be the name of the hidden field name)
     * @return String The generated, base64 encoded token.
     */
    public static function generate( $key )
    {
        $extra = self::$doOriginCheck ? sha1( $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] ) : '';
        // token generation (basically base64_encode any random complex string, time() is used for token expiration) 
        $token = base64_encode( time() . $extra . self::randomString( 32 ) );
        // store the one-time token in session
        $_SESSION[ 'csrf_' . $key ] = $token;

        return $token;
    }

    /**
     * Generates a random string of given $length.
     *
     * @param Integer $length The string length.
     * @return String The randomly generated string.
     */
    protected static function randomString( $length )
    {
        $seed = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijqlmnopqrtsuvwxyz0123456789';
        $max = strlen( $seed ) - 1;

        $string = '';
        for ( $i = 0; $i < $length; ++$i )
            $string .= $seed{intval( mt_rand( 0.0, $max ) )};

        return $string;
    }

}
?>
