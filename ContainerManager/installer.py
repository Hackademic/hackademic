import subprocess
import time

__author__ = 'root'

print "Hackademic sandbox installer"
print "The installer assumes that you have read the README file"
print"\n\n"


mysql_db = raw_input("Enter the hackademic database name\n")
mysql_password = raw_input("Enter the password used for mysql in hackademic setup\n")
subprocess.call("./grant_priv.sh " + mysql_db + " " + mysql_password,shell=True)

#copy the files check.php and my trychallenges.php to hackademic-next installation
print "\nPrepping hackademic-next installation for sandbox enviorment\n"
subprocess.call("cp ../check.php /var/www/html/hackademic-next/check.php")
subprocess.call("cp ../controller/class.TryChallengeController.php /var/www/html/hackademic-next/controller/class.TryChallengeController.php")

config_string='#container manager configuration file'

print "Changing SElinux boolean. This will take some time.\n"
subprocess.call("setsebool -P httpd_can_network_connect 1",shell=True)

print 'Setting up configurations file\n\n'

#add global entry in config file
config_string += '\n[global]\n'
container_root_path = raw_input("Enter the root path of the container folder\n")
#hackademic_root_path = raw_input("Enter path of hackademic-next folder")
ip_address = raw_input("Enter the ip address of the system\n")

config_string += 'container root path : ' + container_root_path + '\n'
config_string += 'ip address : ' + ip_address + '\n'



#add container entries
config_string += '\n[container]\n'
default_ram_size = raw_input("Enter the maximum amount of ram to be allocated to each container\n")
install_number = raw_input("Enter the number of containers to be installed initially")
start_number = raw_input("Enter the number of containers to be started by default\n")

config_string += 'master name : rootfs\n'
config_string += 'strat number : ' + start_number + '\n'


#add port forwarding details
config_string += '\n[port range]\n'
port_start = raw_input("Enter the starting port number from which ports will be forwarded. Make sure subsequent ports does are not already allocated in MB\n")
config_string += 'start : ' + port_start + '\n'

print config_string

#write config to config file
config_file = open("container.conf","w")
config_file.writelines(config_string)
config_file.close()

#check if mount point exists
subprocess.call("mkdir " + container_root_path,shell=True)


#extract the first container
print "Extracting the first container"
subprocess.call("tar -xvf installaion/resources/rootfs.tar.xz -C " + container_root_path,shell=True)


#copy hackademic-next to container
subprocess.call("cp /var/www/html/hackademic-next " + container_root_path + "/rootfs/var/www/html/hackademic-next",shell=True)

#execute virt-install
subprocess.call("virt-install --connect lxc:// --name rootfs --ram " + default_ram_size + " --filesystem " + container_root_path + "/rootfs/,/ --noautoconsole",shell=True)

time.sleep(10)

#chroot and execute first_container_setup.sh
subprocess.call("cp " + "centos_first_install.sh" + container_root_path + "/rootfs/centos_first_install.sh",shell=True)
subprocess.call("chroot " + container_root_path + "/rootfs" + " ./first_container_setup.sh",shell=True)


#copy hackademic-next to rootfs and copy config.inc.php file
subprocess.call("unzip installation/resources/hackademic-next.zip -d " + container_root_path + "/var/www/html")
subprocess.call("cp /var/www/html/hackademic-next/config.inc.php " + container_root_path + "/var/www/html/hackademic-next/config.inc.php")

#install that many containers according to start_number using unionfs-fuse

#make necessary folders
for i in range(1,install_number):

    container_name = "rootfs" + str(i)
    container_folder_name = container_root_path + "/rootfs" + str(i)

    #make necessary folders
    subprocess.call("mkdir " + container_folder_name,shell=True)
    subprocess.call("mkdir " + container_folder_name + "/mount",shell=True)
    subprocess.call("mkdir " + container_folder_name + "/write",shell=True)

    #mount container using unionfs
    subprocess.call("unionfs -o cow,max_files=32768 -o allow_other,use_ino,suid,dev,nonempty   " + container_folder_name + "/write=RW:" + container_root_path+"/rootfs" + "=RO   " + container_folder_name + "/mount",shell=True)

    #change hostname
    subprocess.call("cp container_hostname_setup.sh " + container_folder_name + "/mount/container_hostname_setup.sh",shell=True)
    subprocess.call("chroot " + container_folder_name + "/mount" + " ./container_hostname_setup.sh " + container_name,shell=True)


    #execute virt-install
    subprocess.call("virt-install --connect lxc:// --name " + container_name + " --ram " + default_ram_size + " --filesystem " + container_folder_name + "/mount" +  ",/" + " --noautoconsole",shell=True)


subprocess.call("virsh -c lxc:// destroy rootfs",shell=True)
