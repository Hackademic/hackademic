Feature: Test Container Daemon
  Creating Container Daemon
  Creating connection to Container Daemon
  Sending string
  Receiving string
  Opening URL

  Scenario: Testing GET /challenge
    Given I run the Container Daemon
    When I send "create_container:samplechallenge"
    Then I receive "http://localhost:*/samplechallenge"