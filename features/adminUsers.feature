Feature: Manage Users
	I am at hachademic admin home page an i want to manage users.

	Background:
		Given I am logged in as "admin" with password "admin"

    Scenario: Create 3 users of each role
        Given I access the url "http://localhost/hackademic/admin/pages/adduser.php"
        And I enter "<username>" into the "username" field
        And I enter "<full_name>" into the "full_name" field
        And I enter "<email>" into the "email" field
        And I enter "<password>" into the "password" field
        And I enter "<password>" into the "confirmpassword" field
        And I select "<activated>" from the "activated" field
        And I select "<type>" from the "type" field
        And I click on "submit" button
        Then I see the user success message "User has been added succesfully"
        Examples:
        | username | full_name | email | password | activated | type |
        | student | test student | student@user.gr | 123456 | 1 | 1 |
        | teacher | test teacher | teacher@user.gr | 123456 | 1 | 2 |
        | administrator | administrator user | administrator@user.gr | 123456 | 1 | 3 |

    Scenario: Create another user with same username
        Given I access the url "http://localhost/hackademic/admin/pages/adduser.php"
        And I enter "<username>" into the "username" field
        And I enter "<full_name>" into the "full_name" field
        And I enter "<email>" into the "email" field
        And I enter "<password>" into the "password" field
        And I enter "<password>" into the "confirmpassword" field
        And I select "<activated>" from the "activated" field
        And I select "<type>" from the "type" field
        And I click on "submit" button
        Then I see the user error message "Username already exists"
        Examples:
        | username | full_name | email | password | activated | type |
        | student | test student | student@user.gr | 123456 | 1 | 1 |

    Scenario: Delete 3 users of each role
        Given I access the url "http://localhost/hackademic/admin/pages/usermanager.php"
        And I click on "<username>" link
        And I click on "deletesubmit" button
        Then I see the user success message "User has been deleted succesfully"
        Examples:
        | username |
        | student |
        | teacher |
        | administrator |

    Scenario: Try to delete my self as the only admin
        Given I access the url "http://localhost/hackademic/admin/pages/usermanager.php"
        And I click on "admin" link
        And I click on "deletesubmit" button
        Then I see the user error message "You cant delete the only one admin"




