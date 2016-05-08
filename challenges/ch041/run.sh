#!/bin/bash

# Author Divam Gupta
# github.com/divamgupta

# This shell script starts all the services


php -S 0.0.0.0:8000 index.php &
bash simulate_loop.sh 
