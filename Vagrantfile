# -*- mode: ruby -*-
# vi: set ft=ruby :

VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = " mreil/ubuntu-trusty-mini"
  config.vm.box_url = "http://files.vagrantup.com/precise64.box"

  # config.vm.synced_folder "../data", "/vagrant_data"
  config.vm.synced_folder "./", "/var/www/html/", id: "vagrant-root"
  config.vm.provider "virtualbox" do |v|
    v.memory = 1024
  end

  config.vm.provision "shell",
      inline: "sudo rm -rf /var/www/html"
   config.vm.provision "shell",
      inline: "sudo ln -s /vagrant /var/www/html"
   config.vm.provision "shell",
      inline: "sudo chmod -R 755 /var/www/html"
   config.vm.provision "shell",
      inline: "cd /var/www/html"
   config.vm.provision "shell",
      inline: "sudo chmod 755 ."
   config.vm.provision "shell",
      inline: "sudo service apache2 start && sudo mysqld_safe --skip-grant-tables"

  config.ssh.forward_agent = true
end
