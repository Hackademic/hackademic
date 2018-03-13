exec { 'apt-update':                    # exec resource named 'apt-update'
  command => '/usr/bin/apt-get update'  # command this resource will run
}

# install packages
package {
[gcc, gdb, vim, language-pack-en
 ]: require => Exec['apt-update'],        # require 'apt-update' before installing
  ensure => installed,
}