<?php

require_once 'initTests.php';

class BaseTest extends PHPUnit_Framework_TestCase {
    //use WebDriverAssertions;
    //use WebDriverDevelop;

    /**
     * @var \RemoteWebDriver
     */
    protected static $webDriver;

    protected static function initialize() {
        if(!isset(self::$webDriver)){
        $capabilities = array(\WebDriverCapabilityType::BROWSER_NAME => 'firefox');
        self::$webDriver = RemoteWebDriver::create('http://127.0.0.1:4444/wd/hub', $capabilities);
        
        }
    }

    public function __construct() {
        self::initialize();
    }

    protected static function closeWebDriver() {
        self::$webDriver->close();
    }

    protected static function assertElementFound($element) {
        $el = self::$webDriver->findElement(WebDriverBy::cssSelector($element));
        if (!count($el)) {
            self::fail("Element was found");
        }
    }

    protected static function visit($url) {
        error_log(__METHOD__);
        //$url = str_replace("localhost", "127.0.0.1", $url);
        self::$webDriver->get($url);
    }

    protected static function get_element_by_linkText($content) {

        return self::$webDriver->findElement(WebDriverBy::linkText($content));
    }

    protected static function login($username, $password) {
        error_log(__METHOD__);

        error_log("logging in as " . TEST_USERNAME_ADMIN . " " . TEST_PASSWORD_ADMIN);
        self::visit(SOURCE_ROOT_PATH);
        error_log(SOURCE_ROOT_PATH);
        self::write_to($username, '#inputs > input[type="text"]:nth-child(3)');
        self::write_to($password, '#password');
        sleep(1);
        self::click("#submit");
        sleep(1);
    }

    protected static function logout() {
        error_log(__METHOD__);

        self::click("#mainMenu > li:nth-child(10) > a");
    }
    protected static function type($element, $text){
        BaseTest::write_to($text, $element);
    }
    protected static function write_to($text, $element) {
        error_log(__METHOD__);

        self::click($element);
        self::$webDriver->getKeyboard()->sendKeys($text);
    }

    protected static function click($element) {
        error_log(__METHOD__);
        $search = self::$webDriver->findElement(WebDriverBy::cssSelector($element));
        $search->click();
    }

    protected static function get_element($element) {
        error_log(__METHOD__);

        return self::$webDriver->findElement(WebDriverBy::cssSelector($element));
    }

    protected static function assert_error_message($text) {
        $el = self::get_element("#usermessage > p");
        assert($el->isDisplayed());
        self::assertContains($text, $el->getText());
    }

}

?>