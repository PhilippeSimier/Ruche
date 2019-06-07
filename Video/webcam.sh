#!/bin/bash

raspistill -a 4 -a "%d %B %Y %X" -ae 32,0xFF,0x000080 -t 1000 -w 1296 -h 972 -o /home/pi/video/cam.jpg
scp /home/pi/video/cam.jpg root@172.18.58.9:/var/www/Ruche/video
sleep 18
raspistill -a 4 -a "%d %B %Y %X" -ae 32,0x00,0xFFFF80 -t 1000 -w 1296 -h 972 -o /home/pi/video/cam.jpg
scp /home/pi/video/cam.jpg root@172.18.58.9:/var/www/Ruche/video
sleep 18
raspistill -a 4 -a "%d %B %Y %X" -ae 32,0xFF,0xFFFF80 -t 1000 -w 1296 -h 972 -o /home/pi/video/cam.jpg
scp /home/pi/video/cam.jpg root@172.18.58.9:/var/www/Ruche/video
