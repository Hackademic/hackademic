#!/bin/bash

apt-get update
apt-get install g++ -y
apt-get install g++-multilib -y
apt-get install gdb -y

cd /home/VPTR
g++ -m32 -o vptr vptr.cpp
chmod u+s vptr
chmod 400 flag.txt
echo 0 > /proc/sys/kernel/randomize_va_space