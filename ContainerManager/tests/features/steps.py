from lettuce import *
from subprocess import check_output
import json

communicator_path = '../communicator.py'

@step("I create a docker container for '(.*)'")
def i_create_a_docker_container_for(step, challenge):
    byte_output = check_output([communicator_path, 'create_container', challenge])
    
    # Getting the port number for the newly created container
    slash_split = byte_output.split('/')
    colon_split = slash_split[2].split(':')
    port_no = colon_split[1]
    world.container_port = int(port_no)

@step("I see the container listed")
def i_see_the_container_listed(step):
    byte_output = check_output([communicator_path, 'list_containers'])
    containers = json.loads(byte_output)

    # Getting the Container ID from the port number from previously created container
    world.container_id = ''
    for container in containers:
        if container['Ports'][0]['PublicPort'] == world.container_port:
            world.container_id = container['Id']
            break

    assert world.container_id != '', \
            "Found Container %s" % world.container_id
    

@step("I kill the docker container")
def i_kill_the_docker_container(step):
    check_output([communicator_path, 'kill_container', world.container_id])


@step("I do not see the container listed")
def i_do_not_see_it_listed(step):
    byte_output = check_output([communicator_path, 'list_containers'])
    containers = json.loads(byte_output)

    # Checking whether the Container ID still exist in the list
    containerFound = False
    for container in containers:
        if container['Id'] == world.container_id:
            containerFound = True
            break
    assert not containerFound, "Found Container: %s" % str(containerFound)



