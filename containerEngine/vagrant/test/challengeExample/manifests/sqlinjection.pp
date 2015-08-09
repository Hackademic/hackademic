 class { 'apache': mpm_module => 'prefork'  }
    apache::vhost { 'localhost':
      port    => '80',
      docroot => '/var/www/sqlinjection',
    }
include apache::mod::php
package { ['php5', 'libapache2-mod-php5']:
      ensure => installed,
      notify => Service["apache2"]
  }

  class { '::mysql::server':
  root_password    => 'strongpassword',
  override_options => { 'mysqld' => { 'max_connections' => '1024' } }

}
  mysql_database { 'flag':
  ensure  => 'present',
  charset => 'latin1',
  collate => 'latin1_swedish_ci',
}

file { "/var/www/sqlinjection":
    ensure => directory,
    recurse => true,
    source => "files/sqlinjection/"
}
