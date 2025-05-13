#!/bin/bash


# if [[ "$(uname -s)" == "Linux" ]]; then
#   cp env/prod/.env ./src/.env
# else
#   cp env/dev/.env ./src/.env
# fi
#echo "Environment file copied based on OS..."
#echo "Loading Docker image..."
#docker load -i tm_kmutnb_images.tar
echo "Starting Docker containers..."
docker-compose up -d

echo "Deployment completed!"
