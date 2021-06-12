#!/usr/bin/env bash

docker inspect -f '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' matrix-docker_nginx_1
