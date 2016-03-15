<?php

require_once 'initTests.php';

class BaseTest extends PHPUnit_Framework_TestCase {

    /**
     * @var \RemoteWebDriver
     */
    public static $webDriver;

    public static function initialize() {
        if (!isset(self::$webDriver)) {
            $capabilities = array(\WebDriverCapabilityType::BROWSER_NAME => 'firefox');
            self::$webDriver = RemoteWebDriver::create('http://127.0.0.1:4444/wd/hub', $capabilities);
            error_log("d");
        }
    }

    public function __construct() {
        self::initialize();
    }

    public static function closeWebDriver() {
        self::$webDriver->close();
    }

    public static function assertElementFound($element) {
        $el = self::$webDriver->findElement(WebDriverBy::cssSelector($element));
        if (!count($el)) {
            self::fail("Element was found");
        }
    }

    public static function visit($url) {
        self::$webDriver->get($url);
    }

    public static function getELementByLinkText($content) {
        return self::$webDriver->findElement(WebDriverBy::linkText($content));
    }

    public static function login($username, $password) {
        error_log("logging in as " . TEST_USERNAME_ADMIN . " " . TEST_PASSWORD_ADMIN);
        self::visit(SOURCE_ROOT_PATH);
        self::writeTo($username, '#inputs > input[type="text"]:nth-child(3)');
        self::writeTo($password, '#password');
        self::click("#submit");
    }

    public static function logout() {
        self::visit(SOURCE_ROOT_PATH);
        self::getELementByLinkText("Logout")->click();
    }

    public static function type($element, $text) {
        BaseTest::writeTo($text, $element);
    }

    public static function writeTo($text, $element) {


        self::click($element);
        self::$webDriver->getKeyboard()->sendKeys($text);
    }

    public static function click($element) {
        $search = self::$webDriver->findElement(WebDriverBy::cssSelector($element));
        $search->click();
    }

    public static function getElement($element) {
        return self::$webDriver->findElement(WebDriverBy::cssSelector($element));
    }

    public static function assertErrorMessage($text) {
        $el = self::getElement("#usermessage > p");
        assert($el->isDisplayed());
        error_log($el->getText());
        self::assertContains($text, $el->getText());
    }

    public static function getChallengeUrl($pageSrc) {
        $element = array();
        $url = array();
        preg_match("/\<a.+try_me.+/", $pageSrc, $element);
        preg_match("/\/[\S]+/", $element[0], $url);
        $array1 = explode("/", $url[0]);
        $array2 = explode("/", SOURCE_ROOT_PATH);
        $diff = join(' ', array_diff($array1, $array2));
        return html_entity_decode(SOURCE_ROOT_PATH . $diff);
    }

    public function createUser() {
        BaseTest::login(TEST_USERNAME_ADMIN, TEST_PASSWORD_ADMIN);
        BaseTest::visit(ADMIN_DASHBOARD_URL);
        $this->getELementByLinkText("User Manager")->click();
        $this->click("#content > div.main_content > div.header_bar > div.right.action_button > table > tbody > tr > td:nth-child(1) > div > a > img");
        $this->writeTo($this->username, '#form > table > tbody > tr:nth-child(1) > td:nth-child(2) > input[type="text"]');
        $this->writeTo('Test User1', '#form > table > tbody > tr:nth-child(2) > td:nth-child(2) > input[type="text"]');
        $this->writeTo('testUser1@domain.com', '#email');
        $this->writeTo($this->password, '#password');
        $this->writeTo($this->password, '#confirm_password');
        $this->click('#form > table > tbody > tr:nth-child(6) > td.radio > input[type="radio"]:nth-child(1)');
        $this->click('#submit');
    }

    public function deleteUser($username) {
        BaseTest::visit(ADMIN_DASHBOARD_URL);
        $this->getELementByLinkText("User Manager")->click();
        $this->getELementByLinkText($username)->click();
        $this->click("#deletesubmit");
    }

}