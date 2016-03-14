Feature: Publish Article
	I am at hachademic admin home page an i want to publish
	an new article.
	Background:
		Given I access the url "http://localhost/hackademic/admin"
        And I enter "admin" into the "username" field
        And I enter "admin" into the "pwd" field
        And I click on "submit" button
        Then I see the header "Hackademic CMS"

    Scenario: Publish Article
        Given I access the url "http://localhost/hackademic/admin/pages/addarticle.php"
        And I enter "Test with Cucumber" into the "title" field
        And I select "1" from the "is_published" field
        And I enter "Test with Cucumber is Awesome!!" into the "mce_0" tinymce
        And I click on "submit" button
        Then I see the user success message "Article has been added succesfully"
        

