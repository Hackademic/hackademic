Feature: Increase my points
    In order to increase my points 
    As a student
    I need to be able to solve a challenge
    
    Scenario: Student Can Access Challenges List Page
        Given I am logged in as a student with username "student" and password "manipal"
          And I click "Challenges" link
         Then I should be on "/pages/challengelist.php"
          And should see text matching "Challenges"

    Scenario: Student Can Attempt a Challenge
        Given I am logged in as a student with username "student" and password "manipal"
          And I go to "/pages/challengelist.php"
         Then I should see text matching "Challenges"
          And I click "Challenge 1" link
         Then I should see "Our agents (hackers) informed us"
          And I click "Try it!" link
         Then I should see "GREEK LOGISTICS COMPANY"

  Scenario: Student's point increases after solving problem
      Given I am logged in as a student with username "student" and password "manipal"
        And I should not see "The username or password you entered is incorrect"
        And I go to "/pages/ranking.php"
        And I check the points
       Then I go to "/pages/challengelist.php"
       Then I should see text matching "student"
        And I click "Challenge 2" link
       Then I should see "Your Country needs your help"
        And I click "Try it!" link
       Then I should see "MILITARY SITE"
        And I fill in "Password1" with "enter a coin to play"
        And I store the current user's information
        And I solve Challenge 2
       Then I should see "Congratulations"
       Then I go to "/pages/ranking.php"
        And I should have more points 
    Scenario: Student can access Progress Report Page
        Given I am logged in as a student with username "student" and password "manipal"
          And I click "Progress Report" link
         Then I should be on "/pages/progress.php"
          And should see text matching "Progress Report"
