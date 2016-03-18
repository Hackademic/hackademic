Feature: List containers
    Testing the list container functionality
    By sending the list_container request to the respective port


    Scenario: Simple listing of containers
        Given I have the string 'list_containers'
        Given I connect to port 5506 on localhost
        When I send the string to port 5506
        Then I get the response back from the port
        Then I decode the Json list of containers

    Scenario: Launching a container and then listing containers
        Given I have the string 'list_containers'
        Given I send the string to port 5506
        Given I get the response back from the port
        Given I decode the Json list of containers
        Given I store the Json list of containers as 'previous_list'
        Given I have the string 'create_container:21'
        Given I connect to port 5506 on localhost
        Given I send the string to port 5506
        Given I get the response back from the port
        Given I receive the url of the challenge
        Given I have the string 'list_containers'
        When I send the string to port 5506
        Given I get the response back from the port
        Then I decode the Json list of containers
        Then I assert that the list has grown
