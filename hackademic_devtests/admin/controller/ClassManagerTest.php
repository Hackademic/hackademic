<?php

//require_once 'Testing/Selenium.php';
require(__DIR__ . "/../../../class.BaseTest.php");

class ClassManagerTest extends BaseTest {

    private $class_name = 'unqClass';

    public static function setUpBeforeClass() {
        BaseTest::login(TEST_USERNAME_ADMIN, TEST_PASSWORD_ADMIN);
    }

    public static function tearDownAfterClass() {
        BaseTest::closeWebDriver();
    }

    private function visit_class_manager() {
        BaseTest::visit(ADMIN_DASHBOARD_URL);
        BaseTest::click("#dashboard_table > tbody > tr:nth-child(1) > td:nth-child(3) > p:nth-child(2) > a");
        BaseTest::click("#content > div.main_content > div.header_bar > div.right.action_button > table > tbody > tr > td:nth-child(3) > div > a");
    }

    private function delete_class() {
        $this->visit_class_manager();
        $element = $this->get_element("#" . $this->class_name);
        $el = $element->findElement(WebDriverBy::linkText("Click to delete class!"))->click();
    }

    private function create_class() {
        $this->visit_class_manager();
        $this->click("#content > div.main_content > div.header_bar > div.right.action_button > table > tbody > tr > td > div > a");
        $this->type("#form > table > tbody > tr:nth-child(1) > td:nth-child(2) > input[type=\"text\"]", $this->class_name);
        $this->click("#submit");
    }

    public function test_create_class() {
        $this->create_class();
        $this->delete_class();
    }
    private function archive_class(){
         $this->visit_class_manager();
          $element = $this->get_element("#" . $this->class_name);
          $el = $element->findElement(WebDriverBy::linkText("Click to archive class!"))->click();
    }
    public function test_archive(){
        $this->create_class();
        $this->archive_class();
        $element = $this->get_element("#" . $this->class_name);
        $element->findElement(WebDriverBy::linkText("Click to unarchive class!"));
        $this->delete_class();
    }
    public function test_unarchive() {
        $this->create_class();
        $this->archive_class();
        $element = $this->get_element("#" . $this->class_name);
        $element->findElement(WebDriverBy::linkText("Click to unarchive class!"))->click();
      
        $archived = $this->get_element("#" . $this->class_name);
        $archived->findElement(WebDriverBy::linkText("Click to archive class!"));
        $this->delete_class();
    }

}

?>