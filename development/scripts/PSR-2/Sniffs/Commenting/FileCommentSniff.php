<?php
/**
 * PSR2Extended_Sniffs_Commenting_FileCommentSniff
 *
 * PHP version 5
 *
 * @category PHP
 * @package  CodeSniffer
 * @author   Franck Nijhof <opensource@frenck.nl>
 * @license  http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @link     http://pear.php.net/package/PHP_CodeSniffer
 * @link     http://www.frenck.nl/psr2-extended
 */

if (class_exists('PHP_CodeSniffer_CommentParser_ClassCommentParser', true) === false) {
    throw new PHP_CodeSniffer_Exception(
        'Class PHP_CodeSniffer_CommentParser_ClassCommentParser not found'
    );
}

/**
 * PSR2Extended_Sniffs_Commenting_FileCommentSniff
 *
 * PHP version 5
 *
 * Verifies that :
 * <ul>
 *  <li>A doc comment exists.</li>
 *  <li>There is a blank newline after the short description.</li>
 *  <li>There is a blank newline between the long and short description.</li>
 *  <li>There is a blank newline between the long description and tags.</li>
 *  <li>Check the order of the tags.</li>
 *  <li>Check the indentation of each tag.</li>
 *  <li>Check required and optional tags and the format of their content.</li>
 * </ul>
 *
 * @category PHP
 * @package  CodeSniffer
 * @author   Franck Nijhof <opensource@frenck.nl>
 * @license  http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @link     http://pear.php.net/package/PHP_CodeSniffer
 * @link     http://www.frenck.nl/psr2-extended
 */

class PSR2Extended_Sniffs_Commenting_FileCommentSniff
    extends PEAR_Sniffs_Commenting_FileCommentSniff
{

    /**
     * Tags in correct order and related info.
     *
     * @var array
     */
    protected $tags = array(
        'category'   => array(
            'required'       => false,
            'allow_multiple' => false,
            'order_text'     => 'precedes @package',
        ),
        'package'    => array(
            'required'       => false,
            'allow_multiple' => false,
            'order_text'     => 'follows @category',
        ),
        'subpackage' => array(
            'required'       => false,
            'allow_multiple' => false,
            'order_text'     => 'follows @package',
        ),
        'author'     => array(
            'required'       => false,
            'allow_multiple' => true,
            'order_text'     => 'follows @subpackage (if used) or @package',
        ),
        'copyright'  => array(
            'required'       => true,
            'allow_multiple' => true,
            'order_text'     => 'follows @author',
        ),
        'license'    => array(
            'required'       => false,
            'allow_multiple' => false,
            'order_text'     => 'follows @copyright (if used) or @author',
        ),
        'version'    => array(
            'required'       => false,
            'allow_multiple' => false,
            'order_text'     => 'follows @license',
        ),
        'link'       => array(
            'required'       => true,
            'allow_multiple' => true,
            'order_text'     => 'follows @version (if used) or @license',
        ),
        'see'        => array(
            'required'       => false,
            'allow_multiple' => true,
            'order_text'     => 'follows @link',
        ),
        'since'      => array(
            'required'       => false,
            'allow_multiple' => false,
            'order_text'     => 'follows @see (if used) or @link',
        ),
        'deprecated' => array(
            'required'       => false,
            'allow_multiple' => false,
            'order_text'     => 'follows @since (if used) or @see (if used) or @link',
        ),
    );


    /**
     * Check that the PHP version is specified.
     *
     * @param int    $commentStart Position in the stack where the comment started.
     * @param int    $commentEnd   Position in the stack where the comment ended.
     * @param string $commentText  The text of the function comment.
     *
     * @return void
     */
    protected function processPHPVersion($commentStart, $commentEnd, $commentText)
    {
        //Overrides this function to disable this feature
    }
}
