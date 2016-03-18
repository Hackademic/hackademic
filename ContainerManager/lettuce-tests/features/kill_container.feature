Feature: Kill containers
    Testing the kill container functionality
    By launching some containers
    And subsequently killing them

    Scenario: Launch and then kill a single container
        Given I have the string 'create_container:221'
        Given I connect to port 5506 on localhost
        Given I send the string to port 5506
        Given I get the response back from the port
        Given I receive the url of the challenge
        Given I have the string 'list_containers'
        Given I send the string to port 5506
        Given I get the response back from the port
        Given I decode the Json list of containers
        Given I get the image ID of the container I launched
        Given I have the command created kill_container command
        Given I send the string to port 5506
        Given I connect to port 5506 on localhost
        Given I have the string 'list_containers'
        Given I send the string to port 5506
        Given I get the response back from the port
        When I decode the Json list of containers
        Then I assert that the image has been killed
