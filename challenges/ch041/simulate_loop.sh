#!/bin/bash

# Author Divam Gupta
# github.com/divamgupta

# This shell script runs admin_simulate_job every 7 seconds


while :
do
	phantomjs admin_simulate_job.js 
	sleep 7
done