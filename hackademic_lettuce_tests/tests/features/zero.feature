Feature: Test if Hackademic loaded

    Scenario: Simple Hackademic loading test.
        I go to "http://localhost/hackademic/"
        I should see "Welcome to Hackademic v0.9!"
        I should see an element with id of "logo"

    Scenario: Login with Student
        I fill in "username" with "student"
        I fill in "pwd" with "123"
        I press "submit"
        I should see "Hi student," within 2 seconds
        I should see "Progress Report"
        I should see "Ranking"
        I should see "Challenges"
        I should not see "Add New Articles"
        I should not see "Article Manager"
        I should not see "Users/Classes"
        I should not see "Add New Challenge"
        I should not see "Challenge Managers"
        I should not see "Menu Manager"
        I should not see "Options"
        I should not see "Admin Dashboard"

    Scenario: Validate scoring for challenge 3
        Given I click Challenge 3
        I click "Try it!" on Challenge
        I should see "Try to XSS me using the straight forward way..."
        I input value "<script>alert("XSS!");</script>" and click "try_xss"
        I should see "Congratulations!"
        I close the Challenge

    Scenario: Validate scoring for challenge 4
        Given I click Challenge 4
        I click "Try it!" on Challenge
        I should see "Try to XSS me...Again!"
        I input value "<script>alert(String.fromCharCode(88,83,83,33));</script>" and click "try_xss"
        I should see "Congratulations!"
        I close the Challenge

    Scenario: Validate scoring for challenge 5
        Given I click Challenge 5
        I click "Try it!" on Challenge
        I should see "Unfortunately, you cannot access the contents of this site..."
        I set user agent as "p0wnBrowser"
        I reload the site
        I should see "Congratulations!"
        I close the Challenge
