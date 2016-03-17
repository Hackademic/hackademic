Feature: Publish Article
	I am at hachademic admin home page an i want to publish
	an new article.

	Background:
		Given I am logged in as "admin" with password "admin"

    Scenario: Publish Article
        Given I access the url "http://localhost/hackademic/admin/pages/addarticle.php"
        And I enter "Test with Cucumber" into the "title" field
        And I select "1" from the "is_published" field
        And I enter "Test with Cucumber is Awesome!!" into the "mce_0" tinymce
        And I click on "submit" button
        Then I see the user success message "Article has been added succesfully"
    
    Scenario: Publish Article without Title
        Given I access the url "http://localhost/hackademic/admin/pages/addarticle.php"
        And I enter "" into the "title" field
        And I select "1" from the "is_published" field
        And I enter "Test with Cucumber is Awesome!!" into the "mce_0" tinymce
        And I click on "submit" button
        Then I see the user error message "Title of the article should not be empty"

    Scenario: Publish Article without Content
        Given I access the url "http://localhost/hackademic/admin/pages/addarticle.php"
        And I enter "Testing with Cucumber" into the "title" field
        And I select "1" from the "is_published" field
        And I enter "" into the "mce_0" tinymce
        And I click on "submit" button
        Then I see the user error message "Article post should not be empty"



