<?php
//http://codeception.com/11-12-2013/working-with-phpunit-and-selenium-webdriver.html

require_once(__DIR__."/../../config.inc.php");

class BaseTest extends  PHPUnit_Framework_TestCase{
	//use WebDriverAssertions;
    //use WebDriverDevelop;
	
     /**
     * @var \RemoteWebDriver
     */
    protected $webDriver;
	
    public function __construct()
    {
        $capabilities = array(\WebDriverCapabilityType::BROWSER_NAME => 'firefox');
        $this->webDriver = RemoteWebDriver::create('http://127.0.0.1:4444/wd/hub', $capabilities);
   		error_log("super constructor");
    }
	protected function assertElementFound($element){
		$el = $this->webDriver->findElement(WebDriverBy::cssSelector($element));
		if(!count($el)){
			$this->fail("Element was found");
		}
	}
	protected function get_element_by_linkText($content){
		
		return $this->webDriver->findElement(WebDriverBy::linkText($content));
		
	}
	protected function login($username,$password){
		error_log("logging in");
		$this->visit(SOURCE_ROOT_PATH);
		error_log(SOURCE_ROOT_PATH);
		$this->write_to($username,'#inputs > input[type="text"]:nth-child(3)');
		$this->write_to($password,'#password');
		sleep(1);
		$this->webDriver->getKeyboard()->pressKey(WebDriverKeys::ENTER);
        	
	}
	protected function logout(){
		$this->click("#mainMenu > li:nth-child(10) > a");
	}
	protected function visit($url){
		$url = str_replace("localhost", "127.0.0.1", $url);
		$this->webDriver->get($url);
	}
	/*
	 *  
	 * */
	protected function write_to($text,$element){
		$this->click($element);
        $this->webDriver->getKeyboard()->sendKeys($text);
	}
	protected function click($element){
		 $search = $this->webDriver->findElement(WebDriverBy::cssSelector($element));
		 $search->click();
	}
	protected function get_element($element){
		return $this->webDriver->findElement(WebDriverBy::cssSelector($element));
	}
	
	protected function assert_error_message($text){
		$el = $this->get_element("#usermessage > p");
		assert($el->isDisplayed());
		$this->assertContains($text,$el->getText());
	}
}
?>