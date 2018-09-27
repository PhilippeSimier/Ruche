# Envoyer un SMS avec GAMMU

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
pi@PI1003:~ $ sudo gammu-config
                                                                                
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
pi@PI1003:~ $ sudo gammu identify

Device               : /dev/ttyUSB0
Manufacturer         : Quectel_Ltd
Model                : unknown (Quectel_M95)
Firmware             : M95AR01A21
IMEI                 : 863071014745126
SIM IMSI             : 208019006134389

```
Comme le montre l'écran ci-dessus nous obtenons différentes informations sur le constructeur, le modèle,  le firmware, le numero IMEI etc...

## Envoyer un SMS

```bash
pi@PI1003:~ $ sudo gammu sendsms TEXT 0689744236 -text "gammu message"

If you want break, press Ctrl+C...
Sending SMS 1/1....waiting for network answer..OK, message reference=254

```

##Configurer le daemon gammu 

Gammu SMSD

Gammu SMS Daemon is a program that periodically scans GSM modem for received messages, stores them in defined storage and also sends messages enqueued in this storage. It is perfect tool for managing big amounts of received or sent messages and automatically process them. 

```bash
more /etc/gammu-smsdrc 
```
[lien vers leedom](https://github.com/mbuffat/Jeedom-Gammu) 

 
 



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



