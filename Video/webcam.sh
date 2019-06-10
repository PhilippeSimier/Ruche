#!/bin/bash

OUTPUT=/var/tmp/ram_drive

for i in $(seq 1 19)
do
  raspistill -a 4 -a "%d %B %Y %X" -ae 32,0xFF,0x000080 -t 1000 -w 1296 -h 972 -o "${OUTPUT}"/cam.jpg
  scp "${OUTPUT}"/cam.jpg root@172.18.58.9:/var/www/Ruche/video
  sleep 1
done


