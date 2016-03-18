Feature: Spawn containers
    Testing the create container functionality
    By initializing the daemon and then
    sending a request to the respective port

    Scenario: Creating a single container
        Given I have the string 'create_container:21'
        Given I connect to port 5506 on localhost
        When I send the string to port 5506
        Then I get the response back from the port
        Then I receive the url of the challenge

    Scenario Outline: Create containers [0-4]
        Given I have the string <command>
        Given I connect to port 5506 on localhost
        When I send the string to port 5506
        Then I get the response back from the port
        Then I receive the url of the challenge

        Examples:
        | command                   |
        | 'create_container:0'      |
        | 'create_container:1'      |
        | 'create_container:2'      |
        | 'create_container:3'      |
        | 'create_container:4'      |
