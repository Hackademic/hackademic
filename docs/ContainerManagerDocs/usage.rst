Usage
=====

The entire ContainerEngine has 3 parts:

    * **Communicator**:        Acts as a medium for communication between python and PHP.

    * **ContainerDaemon**:     Maintains the containers/retrieve information about running containers/create/kill containers
    * **ContainerController**: Shows realtime information in the frontend about the containers running with an option to create/kill containers.

ContainerDaemon
---------------

**ContainerDaemon** is the most essential part of the engine. It facilitates container management with listing container information and option to create new containers or to kill existing containers.

When the containerDaemon is launched, it creates a new socket connection via the port ``5506`` and all the interprocess communication happens through this socket. In order to communicate from PHP, an intermediate script named ``communicator`` is used. You can simply launch the container daemon like this:

.. code-block:: bash

    python container_daemon.py&

The ``&`` symbol is used so that the process will run in the background.

.. warning::
    It is very necessary that containerDaemon is running at all the times to make sure containers are properly managed. Just launch the container once and it will run as a background process. If the process gets killed for some reason, it has to be manually restarted or else ContainerEngine will fail to work properly.

Container AutoKiller
^^^^^^^^^^^^^^^^^^^^
Every single container launched will have a maximum live time of **1 hour**. When a container exceeds the time limit, it is automatically killed by the daemon without any furthur notice. This is done with the help of a daemon child process which checks every **5 minutes** for containers who has exceeded the time limit and kills it.


Communicator
------------

Communicator facilitates the communication between the PHP (which shows information to the users via the front end CMS) and the container daemon (which can maintain the containers in the backend).

.. code-block:: bash

    Usage: communicator.py [command] [optional arguments]
    
    eg:
    
    ./communicator.py create_container challenge_name # Creates new container and gives back the link to the challenge
    
    ./communicator.py list_containers  # Gives back container informations like status, container id, commands running etc.
    
    ./communicator.py kill_container container_id  # Kills the container with the specified id.


The communicator uses the socket for communicating with the daemon and results are returned back in ``JSON`` so that formating the retrieved data is easier. All the methods listed above is also available via the front end controllers.

Container Controller
--------------------

The container controller is the PHP script which shows the container details in the front end through which admin can:

    * List all the information about the currently running containers including Status, Uptime, Container ID etc.
    * Create new containers at will
    * Kill any containers if necessary

The controller basically uses the communicator to communicate with daemon over the sockets and results are returned back in ``JSON``. The result is then parsed and shown to the admin. You can see the stats on ``http://ip-address/hackademic/?url=admin/containers``
