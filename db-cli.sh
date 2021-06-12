#!/usr/bin/env bash

echo mysql -h $(docker inspect -f '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' matrix-docker_mysql_1) -u root -p$(grep MYSQL_PASSWORD site-code/.env | awk  '{split($0,a,"="); print a[2]}') matrix
mysql -h $(docker inspect -f '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' matrix-docker_mysql_1) -u root -p$(grep MYSQL_PASSWORD site-code/.env | awk  '{split($0,a,"="); print a[2]}') matrix
