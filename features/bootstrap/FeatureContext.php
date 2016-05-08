<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;

use Behat\MinkExtension\Context\MinkContext;

/**
 * Features context.
 */
class FeatureContext extends MinkContext
{

    private $currentStudentPoints;
    private $studentUsername;
    private $studentPassword;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given I am logged in as a student with username :arg1 and password :arg2
     * @param $arg1
     * @param $arg2
     */
    public function iAmLoggedInAsAStudent($arg1, $arg2)
    {
        $this->visit('/index.php');

        $this->studentUsername = $arg1;
        $this->studentPassword = $arg2;

        $this->fillField('username', $this->studentUsername);
        $this->fillField('password', $this->studentPassword);
        $this->pressButton('Login');
    }


    /**
     * @Given I click :arg1 link
     */
    public function iClickLink($arg1) {
        $this->clickLink($arg1);
    }


    /**
     * @Given I check the points
     */
    public function ICheckPoints() {
        $session = $this->getSession();
        $page = $session->getPage();

        $table = $this->getSession()->getPage()->find('xpath', '//td[text()="'.$this->studentUsername.'"]/following-sibling::td[3]');
        $this->currentStudentPoints = $table->getText();
    }


    /**
     * @Given I should have more points
     */

    public function assertCheckboxNotChecked() {

        $session = $this->getSession();
        $page = $session->getPage();

        $table = $this->getSession()->getPage()->find('xpath', '//td[text()="'.$this->studentUsername.'"]/following-sibling::td[3]');
        $newPoints = $table->getText();

        if ($newPoints == $this->currentStudentPoints) {
            throw new Exception('Points did not increase.');
        }
    }


    /**
     * @Then  I click the input :arg1
     */
    public function iClickOn($arg1) {
        $this->pressButton($arg1);
    }

    /**
     * @Then  I store the current user's information
     */
    public function iStoreCurrentInformation() {
        $url = $this->getSession()->getCurrentUrl();
        $this->currentStudentInfo = explode("?", $url)[1];
    }

    /**
     * @Then I solve Challenge 2
     */
    public function iSolveChallenge2() {
        $this->visit("/challenges/ch002/index.php?Result=enter%20a%20coin%20to%20play&".$this->currentStudentInfo);
    }



}
