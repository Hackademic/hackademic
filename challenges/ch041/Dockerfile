
# Author Divam Gupta
# github.com/divamgupta

# This Dockerfile is used to create a docker image for the container


FROM ubuntu:latest

# Install Dependencies :
RUN apt-get update && \
	apt-get install -y make g++ python git curl software-properties-common phantomjs && \
	add-apt-repository ppa:eugenesan/ppa && \
	apt-get update && \
	apt-get install -y php5

# Setup the workspace
RUN  mkdir xss-sessionhijack-challenge 
WORKDIR xss-sessionhijack-challenge 

# Copy all the files
COPY * ./

EXPOSE 8000

# Run the services
CMD ["bash" , "run.sh"]

# docker build -t chall1 .
# docker run -d -p 0.0.0.0:8001:8000 chall1