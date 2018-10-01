# Envoyer et recevoir un SMS avec GAMMU

**Gammu** est un outil en ligne de commande qui permet la gestion de nombreux modem GSM.
Toutes les commandes de libGammu peuvent être utilisées en ligne de commande. 
**libGammu** est une bibliothèque exportant toutes les fonctionnalités de Gammu pour utilisation dans les programmes C. 
 Par la suite nous utiliseront le modem GSM **Quectel_M95** connecté via un  **click USB adapter** sur un port USB de la raspberry pi.

## Installer gammu

```bash
pi@PI1003:~ $ sudo apt install gammu
pi@PI1003:~ $ sudo apt-get install libgammu-dev
```

## Configurer gammu
Sur OS Linux, le fichier de configuration est recherché dans l'ordre suivant:

```bash
$XDG_CONFIG_HOME/gammu/config
~/.config/gammu/config
~/.gammurc
/etc/gammurc
```
Ce fichier utilise la syntaxe de fichier ini.

Vous pouvez utiliser **gammu-config** ou **gammu-detect** pour générer un fichier de configuration ou démarrer à partir d'un exemple entièrement documenté.

```bash
pi@PI1003:~ $ gammu-config
                                                                                
               ┌───────────────────────────────────────────────┐
               │ Current Gammu configuration                   │      
               │                                               │
               │  P Port                 (/dev/ttyUSB0)        │ 
               │  C Connection           (at115200)            │
               │  M Model                (at)                  │
               │  D Synchronize time     (yes)                 │ 
               │  F Log file             (/home/pi/gammu.log)  │ 
               │  O Log format           (textdate)            │
               │  L Use locking          ()                    │
               │  G Gammu localisation   ()                    │
               │  H Help                                       │
               │  S Save                                       │
               │                                               │
               │                                               │
               │          <Ok>              <Cancel>           │
               │                                               │
               └───────────────────────────────────────────────┘ 
```
les paramètres suivant doivent être renseignés, le Port  **/dev/ttyUSB0**
la vitesse de la transmission:  **at115200**
le modele: **at**      AT Generic phones
L'emplacement du fichier Log file  **/home/pi/gammu.log**
le format du log **textdate**

## Reconnaître le modem

A ce stade il est possible de vérifier si le modem est bien reconnu par gammu.
```bash
pi@PI1003:~ $ gammu identify

Device               : /dev/ttyUSB0
Manufacturer         : Quectel_Ltd
Model                : unknown (Quectel_M95)
Firmware             : M95AR01A21
IMEI                 : 863071014745126
SIM IMSI             : 208019006134389

```
Comme le montre l'écran ci-dessus nous obtenons différentes informations sur le constructeur, le modèle,  le firmware, le numero IMEI etc...

## Débloquer la carte SIM avec le code PIN

Pour envoyer ou recevoir des sms, la première chose à faire est de débloquer la carte SIM avec le code PIN requis. Ici, nous utilisons une carte SIM  avec le code pin est 0000.

```bash
pi@raspberrypi3:~ $ gammu entersecuritycode PIN 0000
```

Au bout de quelques secondes vous devriez voir la led rouge passer d'un clignotement rapide à un clignotement lent.

## Envoyer un SMS

```bash
pi@PI1003:~ $ gammu sendsms TEXT 0689744236 -text "gammu message"

If you want break, press Ctrl+C...
Sending SMS 1/1....waiting for network answer..OK, message reference=254

```
## Recevoir un SMS

Afin de voir vos sms reçus vous pouvez rentrer la commande suivante:

```bash
pi@raspberrypi3:~ $ gammu getallsms
Location 1, folder "Boîte de réception", SIM memory, Inbox folder
SMS message
SMSC number          : "+33689004000"
Envoyé              : sam. 29 sept. 2018 22:09:22  +0200
Coding               : Default GSM alphabet (no compression)
Remote number        : "+33689744236"
État                : UnRead

J'ai manqué votre appel.



1 SMS parts in 1 SMS sequences


```

[lien vers Jeedom](https://github.com/mbuffat/Jeedom-Gammu) 

 

--------

  



## Changelog

 **04/08/2018 :** Ajout du README . 
 **10/09/2018 :** Ajout du  script shell RaspbianOSsetup.sh
 
> **Notes :**


> - Licence : **licence publique générale** ![enter image description here](https://img.shields.io/badge/licence-GPL-green.svg)
> - Auteur **Philippe SIMIER Lycée Touchard Le Mans**
>  ![enter image description here](https://img.shields.io/badge/built-passing-green.svg)
<!-- TOOLBOX 

Génération des badges : https://shields.io/
Génération de ce fichier : https://stackedit.io/editor#



