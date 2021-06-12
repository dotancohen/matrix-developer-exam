#!/usr/bin/env bash

# Return base address of server running in Docker container

docker inspect -f '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' matrix-docker_nginx_1
