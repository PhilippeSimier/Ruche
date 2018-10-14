#!/bin/sh
# script exécuté par le démon Gammu lors de la reception d'un SMS
# ce script envoie le message recu vers thingSpeak
# variables d'environnement
# SMS_1_CLASS
# SMS_1_NUMBER= numero tel
# SMS_1_TEXT= message
# SMS_MESSAGES = le nbre de SMS reçus
# en argument le fichier contenant le SMS

SMS_1_TEXT='https://api.thingspeak.com/update?api_key=BUNNFRUOOIJ4HM7X&field1=0&field2=25&field3=1024'

curl --request GET \
  --url $SMS_1_TEXT \
  --header 'cache-control: no-cache'
