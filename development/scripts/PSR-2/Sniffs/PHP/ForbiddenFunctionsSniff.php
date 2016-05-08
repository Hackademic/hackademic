<?php
/**
 * PSR2Extended_Sniffs_PHP_ForbiddenFunctionsSniff.
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Franck Nijhof <opensource@frenck.nl>
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 * @link      http://www.frenck.nl/psr2-extended
 */

if (class_exists('Generic_Sniffs_PHP_ForbiddenFunctionsSniff', true) === false) {
    throw new PHP_CodeSniffer_Exception('Class Generic_Sniffs_PHP_ForbiddenFunctionsSniff not found');
}

/**
 * PSR2Extended_Sniffs_PHP_ForbiddenFunctionsSniff.
 *
 * Discourages the use of alias functions that are kept in PHP for compatibility
 * with older versions. Can be used to forbid the use of any function.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Franck Nijhof <opensource@frenck.nl>
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 * @link      http://www.frenck.nl/psr2-extended
 */
class PSR2Extended_Sniffs_PHP_ForbiddenFunctionsSniff extends Generic_Sniffs_PHP_ForbiddenFunctionsSniff
{

    /**
     * A list of forbidden functions with their alternatives.
     *
     * The value is NULL if no alternative exists. IE, the
     * function should just not be used.
     *
     * @var array(string => string|null)
     */
    protected $forbiddenFunctions = array(
        'sizeof'                => 'count',
        'delete'                => 'unset',
        'print'                 => 'echo',
        'ereg'                  => 'preg_match',
        'key_exists'            => 'array_key_exists',
        'strchr'                => 'strstr',
        'show_source'           => 'highlight_file',
        'chop'                  => 'rtrim',
        'diskfreespace'         => 'disk_free_space()',
        'doubleval'             => 'floarval',
        'fputs'                 => 'fwrite',
        'gzputs'                => 'gzwrite',
        'imap_create'           => 'imap_createmailbox',
        'imap_fetchtext'        => 'imap_body',
        'imap_header'           => 'imap_headerinfo',
        'imap_listmailbox'      => 'imap_list',
        'imap_listsubscribed'   => 'imap_lsub',
        'imap_rename'           => 'imap_renamemailbox',
        'imap_scan'             => 'imap_listscan',
        'imap_scanmailbox'      => 'imap_listscan',
        'ini_alter'             => 'ini_set',
        'is_double'             => 'is_float',
        'is_integer'            => 'is_int',
        'is_long'               => 'is_int',
        'is_real'               => 'is_float',
        'is_writeable'          => 'is_writable',
        'join'                  => 'implode',
        'pos'                   => 'current',
        'var_export'            => null,
        'error_log'             => null,
        'is_null'               => null,
        'create_function'       => null,
        'eval'                  => null,
    );


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        $tokens = parent::register();
        $tokens[] = T_PRINT;
        return $tokens;

    }//end register()


}//end class

?>