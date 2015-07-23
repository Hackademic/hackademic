##Hackademic Vagrant Sandboxed for Challenges

**Aim:** Create a framework for challenge developers to create vulnerable environment with known vulnerabilities and services, by employing Vagrant for creating VMs and Puppet for managing configuration of the selected operating system.


**Quick Summary:** The outcome of the project will be a framework which can be used by challenge developers. They’ll create a “XML” config along with vulnerable setup, and vagrant will parse this config to create a vulnerable environment in VM. Puppet will be employed for configuration of guest operating system. If mentioned in config file, it will also generate a random flag or “Loot” that challenge. The framework will also have API to create a vulnerable environment by picking few of these vulnerable applications randomly to create a new VM. As a part of the project an introductory challenge will also be created. 

**Table of contents:**

- Introduction
- Problem Statement
- Proposed Solution / Approach
- Deliverables
- Timeline
- References

<hr>
**Introduction:**

Virtual machines are generally used as vulnerable environment to teach ethical hacking. It allows live experience on a sandboxed vulnerable machine. But it is static, i.e once a challenge has been completed, it’s not very beneficial to use it again. So creating vulnerable machines with randomized vulnerabilities and services solves this problem. This can be achieved by using Vagrant and Puppet.

**Vagrant:** is a system for creating VMs, primarily used by software developers to create and share reproducible and portable development environments.[1]

**Vagrant-box:** Image of an environment used by vagrant. Several public vagrant boxes are available at Hashicorp Atlas. [3]

**Puppet:** is a system for remotely managing the configuration of Unix-like and Windows systems. [2]

**Problem Statement:**
 - Vagrant and Puppet installation along with Hackademic installation.
 - Structure of the configuration file to be created by challenge developer.
 - What happens when a challenge is created?
 - What happens when a challenge is attempted?
 - Frontend to view information about deployed vagrant boxes, and options to control them.
 
**Proposed Solution / Approach:**
 - Vagrant and Puppet needs to be installed along with Hackademic. But since these are large files, it's most advisable to ask admins to install them separately. The framework will have direct APIs to check if Vagrant/Puppet is installed, if yes it’d tell version information. Once installed, challenge developers would be able to upload such challenges. We can automate installation of Vagrant and Puppet as well, though I believe it's better to keep this option configurable.

 - The challenge developer needs to specify certain information about the environment, they want so an “XML” config file will be used with following information:
 -- basebox: basebox need to be one defined in system. By defined it means one that has already been imported to system by Vagrant or those that exist in Hashicorp atlas. We shall list them at challenge upload section.
 -- files/folder to place in vagrant box, with path information (this could be used for placing vulnerable application / service in vagrant box).
 -- puppet manifest file path: the challenge developer need to upload the puppet manifest to be used for configuring the system. 
 -- Metadata about the challenge - name, category, level
 -- flag file path: every challenge would have a flag. This will be used to update flag value with a random string every time a new challenge is launched. The API will return information about the flag(s), for each challenge.
 -- shell scripts: there could be a provision for running shell script in created VMs like before the files have been moved or after that. This could for example be used to add data to database by calling  a php code or like creating random directories. This would give extra capability to challenge developers to mod the environment as per their needs.


 - When a challenge is created, it will be first checked if the vagrant box name specified exist or not. And if the requested vagrant box passes size constraint set by admin (Admin shall be able to set constraint on no of boxes in system, max size for them etc ) then the specified vagrant box will be added to system if it doesn’t already exist. 
In this step a directory would be created with name as a random + unique id. And a vagrant file with config would be created. If the challenge developer provides a puppet manifest, the manifest will be moved to manifest folder as default.pp. All the files uploaded by the challenge creator shall be kept in a file directory, and file provisioners will be created for them in vagrantfile corresponding to data in config xml. So the directory structure will look like
<challenge_dir><br>
|---boxes<br>
&nbsp;&nbsp;&nbsp;&nbsp;|---box_id_1<br>
&nbsp;&nbsp;&nbsp;&nbsp;|---box_id_2<br>
&nbsp;&nbsp;&nbsp;&nbsp;|---box_id_3<br>
|---challenges<br>
&nbsp;&nbsp;&nbsp;&nbsp;|---box_id_1_1<br>
&nbsp;&nbsp;&nbsp;&nbsp;|---box_id_1_2<br>
&nbsp;&nbsp;&nbsp;&nbsp;|---box_id_2_1<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|---vagrantfile<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|---files<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|---manifest<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|--- default.pp<br>

 - When a user attempts to try the challenge, we’d create a clone of the directory for that challenge and initialise a VM using those settings. All files in the files directory shall be moved to guest OS using file provisioners in vagrantfile.
Also so as to make the VM available via internet we can choose one of these methods:
Port Forwarding on host machine. Whenever a challenge is started a random available port on host OS is selected for each of port needed on Guest OS and forwarded. In the UI the user’ll be given information on how to connect to services.
Add host data for the IP of VM, such that we create a new subdomain for each challenge.
Once the user closes the challenge, the VM for that challenge will be destroyed.

 - Frontend options:
Option to set threshold on no of box, max size of a single box, max total disk size usage by vagrant / puppet, no of active instances etc.
A list to view different boxes added to system + option to delete them / view more information on them.
A list of active VMs + option to destroy them, halt them or suspend them. The above mentioned controls will be available on the daemon. It’ll will allow Hackademic to programmatically control Vagrant to create, run, halt and destroy a VM.

So overall the architecture of daemon will be like:
The daemon can be started, ended as <daemon> start, <daemon> kill
The process will have a listener to named pipe which will create a new thread whenever data is buffered to the pipe, perform required action, organise the data and send it back to calling script and destroy the thread.
The data can be sent to the daemon via pipes in commands like
create <xml file path>, returns box id
start <box id>, returns {challenge id, subdomain, ip, port etc}
stop <challenge id>, returns status
query all, return information about all box
query active, return information about each active VM
… and more shall be added as per requirement

**Deliverables:**
 - Framework to deploy vulnerable environment based on Vagrant and Puppet.
 - A lightweight example of a challenge developed using the framework.
 - PEP-8 compliant code in all provided python code
 - Sphinx friendly comments
 - Unit tests / Functional tests for code written.
 - Proper documentation on how to use the framework.

**Timeline:**
 - **22 July - 27 July:** Write python daemon with listener to named pipes.
 - **28 July - 4th August:** Code to parse xml, load data to memory and create vagrant file according to it, to create a vagrant box.
 - **5th August - 11th August:** Code to perform action for start, stop, destroy, query commands.
 - **12th August - 19th August:** An example challenge using this framework, start unit testing
 - **20th August - 28th August:** Unit testing, documentation and improvements.


**References:**
 - Vagrant: - https://www.vagrantup.com/
 - Puppet: - https://puppetlabs.com/
 - Hashicorp Atlas - https://atlas.hashicorp.com/boxes/search


