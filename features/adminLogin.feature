Feature: Admin Login
	I am at hachademic home page an i want to login
	as admin with password "admin"

    Scenario: Login as Admin
        Given I access the url "http://localhost/hackademic/admin"
        And I have entered "admin" into the "username" field
        And I have entered "admin" into the "pwd" field
        And I click on "submit" button
        Then I see the header "Hackademic CMS"
