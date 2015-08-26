# execute 'apt-get update'
exec { 'apt-update':                    # exec resource named 'apt-update'
  command => '/usr/bin/apt-get update'  # command this resource will run
}

# install apache2 package
package { 'apache2':
  require => Exec['apt-update'],        # require 'apt-update' before installing
  ensure => installed,
}

# ensure apache2 service is running
service { 'apache2':
  ensure => running,
}

# install mysql-server package
package { 'mysql-server':
  ensure => installed,
}

# install php5 package
package { 'php5':
  require => Exec['apt-update'],        # require 'apt-update' before installing
  ensure => installed,
}

# ensure mysql service is running
service { 'mysql':
  require => Package['mysql-server'],
  ensure => running,
}

# Install apache 2 package
package {'php5-mysql':
	require => Exec['apt-update'],
	ensure => installed,
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
