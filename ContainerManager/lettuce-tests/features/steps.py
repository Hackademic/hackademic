import socket
import sys
import json
from docker import Client
from lettuce import *


@step(u'I have the string \'([^\']*)\'')
def string_issued(step, command):
    world.command = str(command)


@step('I connect to port 5506')
def create_connection(step):
    world.sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    world.server_address = ('localhost', 5506)
    world.sock.connect(world.server_address)


@step('I send the string to port 5506')
def send_request(step):
    world.sock.sendall(world.command)


@step('I get the response back from the port')
def get_response(step):
    world.response = world.sock.recv(9999)


@step('I receive the url of the challenge')
def get_url(step):
    world.url = str(world.response)
    world.challenge_no = world.command.split(':')[1]
    assert world.url.split(':')[1] == "//localhost", \
                                      "Got %s" % world.url.split(':')[1]
    assert world.url.split(':')[2].split('/')[1] == world.challenge_no


@step('I decode the Json list of containers')
def decode_json(step):
    world.json_list = json.loads(str(world.response))


@step("I store the Json list of containers as 'previous_list'")
def store_list(step):
    world.previous_list = world.json_list


@step('I assert that the list has grown')
def compare_container_lists(step):
    assert len(world.previous_list) < len(world.json_list), "Got container \
                                                list %s" % str(world.json_List)


@step('I get the image ID of the container I launched')
def kill_single_container(step):
    world.launched_container_id = world.json_list[0]['Id']


@step('I have the command created kill_container command')
def kill_command(step):
    world.command = 'kill_container:'+world.launched_container_id


@step("I assert that the image has been killed")
def check_image_exist(step):
    exist = False
    for i in world.json_list:
        if world.launched_container_id == i['Id']:
            exist = True
            break
    assert not exist
