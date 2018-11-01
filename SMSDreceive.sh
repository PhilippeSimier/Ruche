#!/bin/sh
# script exécuter par le démon Gammu lors de la reception d'un SMS
# variables d'environnement
# SMS_1_CLASS
# SMS_1_NUMBER= numero tel
# SMS_1_TEXT= message
# SMS_MESSAGES = le nbre de SMS reçus
# en argument le fichier contenant le SMS

DATE=`date '+%Y-%m-%d %H:%M:%S'`
echo "$DATE gsm $SMS_1_TEXT" >> /var/log/Ruche/activity.log

if [ "$SMS_1_TEXT" = "ip" ]; then
    retour=`ip a | grep "inet "`
    echo $retour | gammu-smsd-inject TEXT $SMS_1_NUMBER -unicode
fi
exit 0
