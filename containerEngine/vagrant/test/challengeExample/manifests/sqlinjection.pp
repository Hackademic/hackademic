# execute 'apt-get update'
exec { 'apt-update':                    # exec resource named 'apt-update'
  command => '/usr/bin/apt-get update'  # command this resource will run
}

# install packages
package {
[mysql-server,php5,mysql,php5-mysql
 ]: require => Exec['apt-update'],        # require 'apt-update' before installing
  ensure => installed,
}

# ensure apache2 service is running
service { 'apache2':
  ensure => running,
}
# ensure mysql service is running
service { 'mysql':
  require => Package['mysql-server'],
  ensure => running,
}

class { 'apache':
	default_mods        => false,
	default_confd_files => false,
	default_vhost       => false,
}

apache::vhost {'ubuntutrusty641kjdhf.hector':
	port => '80',
	docroot => 'var/www/html/sqlinjection',
}
