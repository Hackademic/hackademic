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
