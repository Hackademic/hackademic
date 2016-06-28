Container Manager
=================

Installation:
-------------

Run the `install.py`script. It will automatically install (if not installed already) and configure Ubuntu base image with the challenges inside the Web_Challenges directory.

Note:
-----

1) You might want to have some patience since if you are running it for the first time, it will be downloading around 350 MB. From the 2nd time, downloading will not be required.

2) If there is any error, please start a new [issue](https://github.com/a0xnirudh/hackademic/issues) with the error that you got from log files located inside the directory `hackademic-logs`.

3) Check for a new build called `hackademic` after the installation. Use the command `docker images` in a terminal and verify there is a new build.

4) If you wanna test out the challenge (A simple phpinfo() as of now) run the command `docker run -d -p 1337:80 hackademic` and after this go to the URL `ip-address:1337/samplechallenge` and see if you are getting the output of phpinfo().

Creating Container:
-------------------

The file `create_container.py` should be called with the challenge name as an arguemnt. Say for eg: if student comes and clicks in **try challenge** then `create_container.py` should be called which will successfully create and host the web challenge in a random port and gives back the absolute url to the challenge.

Student can then visit the URL and access the challenge.

Container Daemon:
-----------------

An always running python script which manages the whole container project. Immediately once the daemon starts, it will spawn a new child which checks for the container details every 5 minutes and the moment a container up time becomes greater than 1 hour, the child will kill the container. The daemon has the following abilities:

1. Create New containers
2. List currently running containers
3. Kill any containers if needed.

Connecting to a Container Daemon:
-----------------

1. Run the `container_daemon.py` script. This will create an listening socket connection on port 5506.
2. Connect to socket connection running on port 5506 using `nc localhost 5506`.
3. Run the challenge by sending `create_container:<challengename>` to the socket connection. This will return the web address of running challenge.

Running Unit Tests using lettuce:
-----------------

1. Install lettuce with pip by running: pip install lettuce
2. Change directory to ContainerManager
3. If running for the first time run install.py to download, install, build and configure the hackademic docker image.
4. Start the container-daemon.py in the background (./container-daemon.py > /dev/null &) 
    OR Run it on another terminal (Recommended for debugging)
5. Change directory to ContainerManager/tests
6. Run 'lettuce' (without quotes)
7. let's lettuce it!

Using the socket API with communicator.py
-----------------

The provided communicator.py script supports 3 commands:
1. create_container <Challenge Name>
2. kill_container <Container ID>
3. list_containers

Example Usage:
    ./communicator.py create_container samplechallenge
    OUTPUT:
    samplechallenge
    http://localhost:4776/samplechallenge

    ./communicator.py list_containers
    OUTPUT:
    [{
        "Status": "Up 15 seconds",
        "Created": 1457876140,
        "Image": "hackademic:latest",
        "Labels": {},
        "NetworkSettings": {
            "Networks": {
                "bridge": {
                    "NetworkID": "",
                    "MacAddress": "02:42:ac:11:00:02",
                    "GlobalIPv6PrefixLen": 0,
                    "Links": null,
                    "GlobalIPv6Address": "",
                    "IPv6Gateway": "",
                    "IPAMConfig": null,
                    "EndpointID": "5db72707f05bf3dfa4f67a9c803e126190293400d7d5f15a84f2e108bd733a4b",
                    "IPPrefixLen": 16,
                    "IPAddress": "172.17.0.2",
                    "Gateway": "172.17.0.1",
                    "Aliases": null
                }
            }
        },
        "HostConfig": {
            "NetworkMode": "default"
        },
        "ImageID": "sha256:9e9357439b68e1d2f8230cd87b307560b1587fa2b36b2ce9649d3942e90416a6",
        "Command": "/sbin/my_init",
        "Names": ["/desperate_hamilton"],
        "Id": "12a7b763a846fc05f1bfb41656ea1d045bfabf0788dc4b795bdf4f1e0c3a1329",
        "Ports": [{
            "IP": "0.0.0.0",
            "Type": "tcp",
            "PublicPort": 4776,
            "PrivatePort": 80
        }]
    }]

    ./communicator.py kill_container 12a7b763a846fc05f1bfb41656ea1d045bfabf0788dc4b795bdf4f1e0c3a1329
    OUTPUT:
    12a7b763a846fc05f1bfb41656ea1d045bfabf0788dc4b795bdf4f1e0c3a1329



A UI has to be added to provide this as an interface to the admin.
