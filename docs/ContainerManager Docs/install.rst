Installation
============

Prerequisites
-------------

There are a few packages which are necessary before proceeding with the installation:

    * Git client: ``sudo apt-get install git``
    * Python 2.7, which is installed by default in most systems
    * Python pip: ``sudo apt-get install python-pip``
    * PHP5, MySQL: ``sudo apt-get install mysql-server php5 php5-mysql``

CMS installation
----------------

Installing Hackademic CMS is as easy as cloning the git repository to ``/var/www/html`` and giving ``chmod 765`` to set appropriate permission to execute hackademic correctly. You can get the complete installation instruction for the hackademic CMS here.


Supported Distros
-----------------

For installing ContainerEngine, as of now, only Debian - Ubuntu variants (apt-get) are supported. We will soon update it to support other distributions.


ContainerEngine installation
----------------------------

Once the CMS is installed properly, simply execute the ``install.py`` file inside the ``ContainerManager`` directory. Here are the complete instructions:

.. code-block:: bash

    cd hackademic/ContainerManager
    python install.py

This will automatically take care of the installation of Container Engine.

.. note::
    
	* Only Debian-Ubuntu variants are supported as of now. 
	* The installation could take sometime to complete and requires a good internet connection (Around 400 MB files has to be downloaded)


