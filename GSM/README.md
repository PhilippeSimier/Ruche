# Transmission de données via réseau GSM

## Présentation
La transmission de données via le **réseau GSM** convient particulièrement lorsque les mesures doivent être réalisées sur une ruche située dans un lieu isolé et éloigné. Un modem GSM  est alors raccordé au raspberry pi sur une prise USB. La transmission des données au modem se fait  via une liaison série. Le modem est piloté par un jeu de commandes standards Hayes appelé aussi commandes AT. Le modem GSM/GPRS intègre une carte SIM  avec un abonnement comprenant des appels limités à 2h mais permettant l'envoi de sms et de mms illimités. La plupart des opérateurs proposent des forfaits de ce genre pour 2€ par mois.

La norme GPRS spécifie le support de transmission de données en mode paquet sur GSM. Ce support permet de transmettre des messages courts appelés SMS à travers des canaux radio GPRS.

## Topologie
![topologie transmission GSM ](/GSM/topologie.png)

La passerelle est  composée d'une raspberry pi et d'un modem GSM. Elle joue le rôle d'intermédiaire en se plaçant entre une ruche connectée et la platforme IOT thingSpeak  pour permettre  leurs échanges. La passerelle fonctionne comme un proxy.

## Protocole de transmission 
L'envoi des données vers la plateforme thingspeak se fait en http avec une requête  GET.  Lorsque la ruche n'est pas directement connectée au réseau ethernet la requête est envoyée vers la passerelle sous la forme d'un ou plusieurs SMS . 
Les requêtes http ou https reçues  par la passerelle dans les SMS sont  réexpédiées tel-quel sur le réseau ethernet et les réponses obtenues  sont renvoyées à l'expéditeur  qui en à fait la demande, également sous la forme de SMS. 
  
![process transmission ](/GSM/TransmissionSMS.PNG)

Le processus thingspeakGET collecte les valeurs mesurées par les capteurs pour préparer la requête à envoyer à la plate-forme thingSpeak. 
```bash
pi@raspberrypi:~/Ruche/Capteurs $ ./thingSpeakGET BUNNFRUOOIJ4HM7X
https://api.thingspeak.com/update?api_key=BUNNFRUOOIJ4HM7X&field1=-3.74&field2=18.67&field3=1032.96&field4=62.30&field5=327.50&field6=11.35&field7=-3.68&created_at=2018-10-22%2013:55:38
```
Cette requête est transmise sur l'entrée  de gammu-smsd-inject  qui transmet son   contenu sous forme de SMS.
Le pipe effectue la connexion entre la sortie de thingspeakGET (création de la requête) et l'entrée de gammu-smsd-inject(envoi de SMS), comme l'illustre la figure ci-dessus.
```bash
*/30 * * * * /home/pi/Ruche/Capteurs/thingSpeakGET BUNNFRUOOIJ4HM7X | gammu-smsd-inject TEXT 0788887777 -len 183
```
du côté de la gateway, lorsque les SMS sont reçus, le script SMSDreceive est exécuté. Sa fonction est de reconstituer la requête en concaténant les SMS reçus :
```bash
REQUETE=$SMS_1_TEXT$SMS_2_TEXT
```
puis de lancer l'exécution du programme envoyerURL.
```bash
retour=`echo "$REQUETE" | /root/envoyerURL`
```
La réponse reçue sera envoyée en retour à l'expéditeur.
```bash
echo $retour | gammu-smsd-inject TEXT $SMS_1_NUMBER -unicode
```
#### le script complet SMSDreceive côté Gateway:
```bash
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
REQUETE=$SMS_1_TEXT$SMS_2_TEXT
echo "message : $REQUETE" >> /root/sms.log

retour=`echo "$REQUETE" | /root/envoyerURL`
echo $retour >> /root/sms.log

echo $retour | gammu-smsd-inject TEXT $SMS_1_NUMBER -unicode

exit 0 
```
#### le script complet SMSDreceive côté Connected Beehive:
```bash
#!/bin/sh
# script exécuter par le démon Gammu lors de la reception d'un SMS
# variables d'environnement
# SMS_1_CLASS
# SMS_1_NUMBER= numero tel
# SMS_1_TEXT= message
# SMS_MESSAGES = le nbre de SMS reçus
# en argument le fichier contenant le SMS

DATE=`date '+%Y-%m-%d %H:%M:%S'`
echo "$DATE gsm $SMS_1_TEXT" >> /home/pi/Ruche/activity.log
```

## Changelog

 **22/10/2018 :** Ajout du README . 
 
 
> **Notes :**


> - Licence : **licence publique générale** ![enter image description here](https://img.shields.io/badge/licence-GPL-green.svg)
> - Auteur **Philippe SIMIER Lycée Touchard Le Mans**
>  ![enter image description here](https://img.shields.io/badge/built-passing-green.svg)
<!-- TOOLBOX 

Génération des badges : https://shields.io/
Génération de ce fichier : https://stackedit.io/editor#



