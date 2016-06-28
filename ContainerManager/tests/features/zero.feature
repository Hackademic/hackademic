Feature: Manipulating Docker Containers
    Creating/Killing/Listing a Docker Container using 
    the provided socket interface and
    running 'samplechallenge'


    Scenario: Create a container with samplechallenge
        When I create a docker container for 'samplechallenge'
        Then I see the container listed


    Scenario: Killing the container
        When I kill the docker container
        Then I do not see the container listed
