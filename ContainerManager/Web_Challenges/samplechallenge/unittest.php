<?php
/**
 * Created by PhpStorm.
 * User: lucif3r
 * Date: 2/10/15
 * Time: 4:08 PM
 */

require_once('/tmp/src.php');

class SrcTest extends PHPUnit_Framework_TestCase
{
    public function setUp(){ }
    public function tearDown(){ }

    public function testIsSanitized()
    {

        $connObj = new Src();
        $payload = "'onload='alert(2)";

        $result = $connObj->sanitize($payload);
        $this->assertNotContains($payload, $result);
    }
}
