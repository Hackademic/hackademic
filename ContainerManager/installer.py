import subprocess

__author__ = 'root'

print "Hackademic sandbox installer"
print "The installer assumes that you have read the README file"


config_string='#container manager configuration file'

print "SElinux boolean has to be changed"
#subprocess.call("setsebool -P httpd_can_network_connect 1",shell=True)

print 'Setting global configurations'

#add global entry in config file
config_string += '\n[global]\n'
container_root_path = raw_input("Enter the root path of the container folder\n")
#hackademic_root_path = raw_input("Enter path of hackademic-next folder")
ip_address = raw_input("Enter the ip address of the system\n")

config_string += 'container root path : ' + container_root_path + '\n'
config_string += 'ip address : ' + ip_address + '\n'



#add container entries
config_string += '\n[container]\n'
default_ram_size = raw_input("Enter teh maximum amount of ram to be allocated to each container\n")
start_number = raw_input("Enter the number of containers to be started by default\n")

config_string += 'master name : rootfs\n'
config_string += 'strat number : ' + start_number + '\n'


#add port forwarding details
config_string += '\n[port range]\n'
port_start = raw_input("Enter the starting port number from which ports will be forwarded. Make sure subsequent ports does are not already allocated\n")
config_string += 'start : ' + port_start + '\n'

print config_string

config_file = open("config.conf","w")
config_file.writelines(config_string)
config_file.close()

#check if mount point exists
subprocess.call("mkdir " + container_root_path,shell=True)



#print "The installer will now download the container image for CentOS 6.6. The best suport is a host operating system which is the same"
subprocess.call("wget http://images.linuxcontainers.org/images/centos/6/i386/default/20150114_02:16/rootfs.tar.gz")

#add it to config file


#extract the first container
print "Extracting the first container"
subprocess.call("tar -xvf rootfs.tar.xz -C " + container_root_path)

#execute first_setup.sh file as chroot
subprocess.call("cp first_setup.sh " + container_root_path + "/mount/first_setup.sh",shell=True)
subprocess.call("chroot " + container_root_path + "/mount" + " ./first_setup.sh " + 'rootfs',shell=True)

#execute virt-install
subprocess.call("virt-install --connect lxc:// --name rootfs --ram " + default_ram_size + " --filesystem " + container_root_path + "/rootfs/,/")

print "Installation complete"
