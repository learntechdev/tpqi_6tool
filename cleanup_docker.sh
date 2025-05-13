#!/bin/bash

echo "Stop All Containers in process..."
#docker stop $(docker ps -q)
docker stop tpqi6_tool_php_1
docker stop tpqi6_tool_mysql_1

echo "Remove All Containers..."
#docker rm $(docker ps -aq)
docker rm tpqi6_tool_php_1
docker rm tpqi6_tool_mysql_1

echo "Remove Images..."
#docker rmi -f $(docker images -q)
docker rmi php:7.4-apache
docker rmi mysql:8.0

echo "Clear All Containers and Images"
