#!/usr/bin/env bash
docker run -d \
       	-p 5000:5000 \
       	-p 1234:8888 \
	--name production-new  -it \
	-v /home/mohamed/Bureau/container-shared:/apps \
	prod-environment:latest bash
