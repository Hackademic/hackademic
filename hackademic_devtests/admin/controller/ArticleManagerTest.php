<?php

require(__DIR__ . "/../../../class.BaseTest.php");

class ArticleManagerTest extends BaseTest {

    private $title = 'unqTitle';
    private $content = 'unqContent';

    public static function setUpBeforeClass() {
        BaseTest::login(TEST_USERNAME_ADMIN, TEST_PASSWORD_ADMIN);
    }

    public static function tearDownAfterClass() {
        BaseTest::closeWebDriver();
    }

    private function delete_article() {
        $this->visit_article_manager();
        $this->get_element_by_linkText($this->title)->click();
        $this->click('#input_form > form > table > tbody > tr:nth-child(3) > td:nth-child(2) > input[type="checkbox"]');
        $this->click('#input_form > form > table > tbody > tr:nth-child(6) > td > p > input[type="submit"]');
    }

    private function visit_article_manager() {
        BaseTest::visit(ADMIN_DASHBOARD_URL);
        $this->get_element_by_linkText("Article Manager")->click();
    }

    public function test_createArticle() {
        $this->visit_article_manager();
        $this->get_element_by_linkText("Add New Articles")->click();
        $this->write_to($this->title, '#input_form > form > table > tbody > tr:nth-child(1) > td:nth-child(2) > input[type="text"]');
        self::$webDriver->executeScript("tinyMCE.activeEditor.setContent('" . $this->content . "')");
        $this->click('#input_form > form > table > tbody > tr:nth-child(2) > td.radio > input[type="radio"]:nth-child(1)');
        $this->click("#submit");
        $this->visit_article_manager();
        $this->get_element_by_linkText($this->title);
        $this->delete_article();
    }
    
    /*TODO: Verify article published
            Unpublish Article
     *      Edit Article
     */

}

?>