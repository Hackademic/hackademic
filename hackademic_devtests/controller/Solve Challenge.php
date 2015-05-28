<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require(__DIR__ . "/../class.BaseTest.php");

class SolveChallenge extends BaseTest{

    protected $username = 'fooUser';
    protected $password = 'aBadPass';

    public static function setUpBeforeClass() {
    }

    public static function tearDownAfterClass() {
        BaseTest::closeWebDriver();
    }

    public function tearDown() {
        $this->logout();
        BaseTest::login(TEST_PASSWORD_ADMIN,TEST_PASSWORD_ADMIN);
        $this->deleteUser($this->username);
    }
    public function setUp(){
        $this->createUser();
        $this->logout();
    }
    public function testSolveChallenge3() {
        BaseTest::login($this->username, $this->password);
        BaseTest::getELementByLinkText("Challenge 3")->click();
        
        $src = BaseTest::$webDriver->getPageSource();
        $url = BaseTest::getChallengeUrl($src);
        $this->visit($url);
        
        BaseTest::writeTo('<script>alert("XSS!");</script>', "body > center > font > h2 > form > input[type=\"text\"]:nth-child(1)");
        
        BaseTest::getElement('body > center > font > h2 > form > input[type="submit"]:nth-child(2)')->click();
        BaseTest::$webDriver->switchTo()->alert()->accept();
        $cSrc = BaseTest::$webDriver->getPageSource();
        BaseTest::assertContains("Congratulations!", $cSrc);
    }
}
