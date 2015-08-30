Challenges
==========


Adding new challenge
--------------------

If you want to add your own challenges to the ContainerEngine (which needs to be executed inside the container) then follow the steps mentioned below:

    #. Create a new challenge directory in ``ContainerManager/Web_Challenges``. Make sure you mandatorly has an ``index.php`` where the challenge begins.
    
    #. Once the directory is created (which should container all necessary files for a challenge including index.php), run the ``install`` script again. It will automatically create a new docker image which has the challenge.
    
    #. Once the install script execution is complete, create a new container with the help of ContainerDaemon (or using communicator) and launch the container.
    
    #. The absolute link will be given back by the communicator once container is created. The link will be in the format: `<http://localhost:port/Web_Challenges/challenge_name/>`_.

.. warning::
    As of now, only PHP based challenges will be accepted by the container. We will soon be supporting other types of challenges involving python scripts/Nodejs/ruby on rails.


Deleting existing challenges
----------------------------

If you want to delete an existing challenge, simply remove the challenge directory from ``/ContainerManager/Web_Challenges/`` and re-run the ``install.py`` script. The challenge will removed automatically.
