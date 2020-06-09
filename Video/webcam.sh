#!/bin/bash

OUTPUT=/var/tmp/ram_drive/cam.jpg
OPTIONS='-t 1000 -w 1296 -h 972 -q 10 --exif none'
unalias cp
for i in $(seq 1 30)
do
  raspistill -a 4 -a "%d %B %Y %X" -ae 32,0xFF,0x000080 $OPTIONS -o $OUTPUT
#  scp $OUTPUT root@172.18.58.9:/var/www/Ruche/video
  cp -f $OUTPUT /home/pi/video/video
done



