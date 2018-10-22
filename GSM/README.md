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
  
![process transmission ](/GSM/TransmissionSMS.png)

## Changelog

 **19/10/2018 :** Ajout du README . 
 
 
> **Notes :**


> - Licence : **licence publique générale** ![enter image description here](https://img.shields.io/badge/licence-GPL-green.svg)
> - Auteur **Philippe SIMIER Lycée Touchard Le Mans**
>  ![enter image description here](https://img.shields.io/badge/built-passing-green.svg)
<!-- TOOLBOX 

Génération des badges : https://shields.io/
Génération de ce fichier : https://stackedit.io/editor#



