<?php

require(__DIR__."/../../controller/class.BaseTest.php");

class AddUserControllerTest extends BaseTest {
	private $unique_username = "unq_uname";
	private $username = "uname";
	
	public function setUp() {
		error_log("setup");
		$this->login("admin","northy");
		}
	public function deleteUser($username){
		$user = $this->get_element_by_linkText("$username");
		$user->click();
		$this->click("#deletesubmit");
	}
	public function tearDown()
    {
		$this->logout();
        $this->webDriver->close();
    }
	public function test_add_user(){
		$this->click("#dashboard_table > tbody > tr:nth-child(1) > td:nth-child(3) > p:nth-child(2) > a > img");
		$this->click("#content > div.main_content > div.header_bar > div.right.action_button > table > tbody > tr > td:nth-child(1) > div > a > img");
		$this->write_to($this->username,'#form > table > tbody > tr:nth-child(1) > td:nth-child(2) > input[type="text"]');
		$this->write_to('Test User1','#form > table > tbody > tr:nth-child(2) > td:nth-child(2) > input[type="text"]');
		$this->write_to('testUser1@domain.com','#email');
		$this->write_to('aBadPass','#password');
		$this->write_to('aBadPass','#confirm_password');
		$this->click('#form > table > tbody > tr:nth-child(6) > td.radio > input[type="radio"]:nth-child(1)');
		$this->click('#submit');

		sleep(1);
		$this->assertEquals($this->webDriver->getCurrentURL(),SOURCE_ROOT_PATH."?url=admin/usermanager&source=add");
		$el = $this->get_element_by_linkText($this->username);
		$this->assertEquals(count($el), 1);
		$user = $this->deleteUser($this->username);
	}
	public function test_wrong_email(){
		$this->click("#dashboard_table > tbody > tr:nth-child(1) > td:nth-child(3) > p:nth-child(2) > a > img");
		$this->click("#content > div.main_content > div.header_bar > div.right.action_button > table > tbody > tr > td:nth-child(1) > div > a > img");
		$this->write_to($this->unique_username,'#form > table > tbody > tr:nth-child(1) > td:nth-child(2) > input[type="text"]');
		$this->write_to('Test User1','#form > table > tbody > tr:nth-child(2) > td:nth-child(2) > input[type="text"]');
		$this->write_to('asdf@','#email');
		$this->write_to('aBadPass','#password');
		$this->write_to('aBadPass','#confirm_password');
		$this->click('#form > table > tbody > tr:nth-child(6) > td.radio > input[type="radio"]:nth-child(1)');
		$this->click('#submit');
		$this->assert_error_message("Please enter a valid email");
	}
	public function test_non_matching_pass(){
		$this->click("#dashboard_table > tbody > tr:nth-child(1) > td:nth-child(3) > p:nth-child(2) > a > img");
		$this->click("#content > div.main_content > div.header_bar > div.right.action_button > table > tbody > tr > td:nth-child(1) > div > a > img");
		$this->write_to($this->unique_username."asd",'#form > table > tbody > tr:nth-child(1) > td:nth-child(2) > input[type="text"]');
		$this->write_to('Test User1','#form > table > tbody > tr:nth-child(2) > td:nth-child(2) > input[type="text"]');
		$this->write_to('asdf@foo.com','#email');
		$this->write_to('aBadPass','#password');
		$this->write_to('aBadPassasdf','#confirm_password');
		$this->click('#form > table > tbody > tr:nth-child(6) > td.radio > input[type="radio"]:nth-child(1)');
		$this->click('#submit');
		$this->assert_error_message("The two passwords dont match!");
	}
	public function test_existing_username(){
		
		$this->click("#dashboard_table > tbody > tr:nth-child(1) > td:nth-child(3) > p:nth-child(2) > a > img");
		$this->click("#content > div.main_content > div.header_bar > div.right.action_button > table > tbody > tr > td:nth-child(1) > div > a > img");
		$this->write_to($this->username,'#form > table > tbody > tr:nth-child(1) > td:nth-child(2) > input[type="text"]');
		$this->write_to('Test User1','#form > table > tbody > tr:nth-child(2) > td:nth-child(2) > input[type="text"]');
		$this->write_to('testUser1@domain.com','#email');
		$this->write_to('aBadPass','#password');
		$this->write_to('aBadPass','#confirm_password');
		$this->click('#form > table > tbody > tr:nth-child(6) > td.radio > input[type="radio"]:nth-child(1)');
		$this->click('#submit');
		
		$this->visit(SOURCE_ROOT_PATH."?url=admin/usermanager");
		$this->click("#content > div.main_content > div.header_bar > div.right.action_button > table > tbody > tr > td:nth-child(1) > div > a > img");
		$this->write_to($this->username,'#form > table > tbody > tr:nth-child(1) > td:nth-child(2) > input[type="text"]');
		$this->write_to('Test User1','#form > table > tbody > tr:nth-child(2) > td:nth-child(2) > input[type="text"]');
		$this->write_to('testUser1@domain.com','#email');
		$this->write_to('aBadPass','#password');
		$this->write_to('aBadPass','#confirm_password');
		$this->click('#form > table > tbody > tr:nth-child(6) > td.radio > input[type="radio"]:nth-child(1)');
		$this->click('#submit');
		
		$this->assert_error_message("Username already exists");
		$this->visit(SOURCE_ROOT_PATH."?url=admin/usermanager");
		$user = $this->deleteUser($this->username);
	}
}
