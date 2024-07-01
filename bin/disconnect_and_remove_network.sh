#!/bin/bash

# Name of the network to remove
NETWORK_NAME="app-network"

# Get all containers connected to the network
CONTAINERS=$(docker network inspect -f '{{range .Containers}}{{.Name}} {{end}}' $NETWORK_NAME)

# Disconnect each container from the network
for CONTAINER in $CONTAINERS
do
  docker network disconnect -f $NETWORK_NAME $CONTAINER
done

# Remove the network
docker network rm $NETWORK_NAME
