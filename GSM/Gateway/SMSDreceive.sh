#!/bin/sh
# script exécuter par le démon Gammu lors de la reception d'un SMS
# variables d'environnement
# SMS_1_CLASS
# SMS_1_NUMBER= numero tel
# SMS_1_TEXT= message
# SMS_MESSAGES = le nbre de SMS reçus
# en argument le fichier contenant le SMS

echo "---------------------------------------" >> /root/sms.log
echo "$(date) : $SMS_MESSAGES  SMS(s) recu(s)" >> /root/sms.log
echo "from : $SMS_1_NUMBER" >> /root/sms.log
requete=$SMS_1_TEXT$SMS_2_TEXT
protocol=`echo $requete | cut -d: -f1`

echo "requete : $requete" >> /root/sms.log

if [ $protocol = "https" -o $protocol = "http" ]; then
    retour=`echo "$requete" | /root/envoyerURL`
    echo $retour >> /root/sms.log

    echo $retour | gammu-smsd-inject TEXT $SMS_1_NUMBER -unicode
fi
exit 0

