# Sigfox

## La carte SNOC BRKWS01

Le breakout **BRKWS01** est une carte  SigFox , basée sur le module Wisol SFM10R1. Cette carte permet  d'utiliser le réseau LPWan SigFox   pour la transmission de données. Le réseau SigFox permet d'envoyer des messages de **12 octets** à raison de 140 messages par jour.

## Activer le module sur le site SigFox

Afin de permettre l’accès au réseau SigFox, il est nécessaire créer un compte utilisateur. 
Le compte utilisateur permet d'activer des modules. l'identifiant ID et le code PAC  de la carte SNOC sont nécessaires pour créer une nouvelle activation. Cette activation autorise le module à émettre et recevoir des données sur le réseau SigFox . La carte BRKWS01 est vendu avec un an d’abonnement découverte inclus.
Quand votre inscription est terminée. Il reste à la valider en suivant le lien que vous avez reçu dans un mail à l’adresse que vous avez fournie. Cliquez sur le lien dans le message pour terminer votre inscription.  Vous devrez alors définir un mot de passe.

[lien vers la page d'activation d'un module](https://buy.sigfox.com/activate)

## Envoi de données via SigFox

Le module est contrôle avec des commandes  AT envoyées sur des broches TX / RX. La communication série: se fait à **9600** bauds, avec **8 bits par caractères**, 1 bit de stop, **sans parité** écho local.

Les commandes AT se font en **majuscules**

Test de Communication:	

    AT
    OK

Récupérer le Module ID:	

    AT$I=10

Récupérer le code PAC:	

    AT$I=11

Envoyer un message :	(Valeur Hexadécimal) donc un nombre de caractères paire

    AT$SF=001122AABBEEFF
    OK


Envoyer un message SIGFOX avec trame de reception:	(Valeur Hexadécimal)

Envoyer 01 .. 06, en attendant une liaison descendante

    AT$SF=010203040506,1                   
    ERR_SFX_ERR_SEND_FRAME_WAIT_TIMEOUT      
     
Réponse obtenue lorsque aucune liaison descendante n'est reçue

Même chose obtenue quand une liaison descendante est reçue avec les 8 octets.

    AT$SF=010203040506,1                  
    OK 
    RX=00 00 0A E1 00 00 FF 8F

## Lire les messages reçus sur l'agrégateur Sigfox

Les messages émis par les devices sont stockés sur l'aggrégator SigFox. Il est possible de les consulter en se connectant sur le site Sigfox côté **backend**.

[Lien vers le backend SigFox](https://backend.sigfox.com/auth/login)

Cliquer sur l'onglet **DEVICE** un tableau des devices activés s'affiche. 
Cliquer sur le **Device ID**  puis sur **MESSAGES** pour afficher la liste des messages envoyés par le module sélectionné.
Chaque message est horodaté.

## Activation du callback

A réception du message, le serveur SigFox va transférer les données vers un serveur désigné par l’utilisateur. C’est ce qu’on appelle un “**callback**”.
Dans l’onglet “**DEVICE TYPE**” du site SigFox, cliquer sur le nom de la carte, pour faire apparaître dans la colonne de gauche un menu comportant l’option **CALLBACKS**.
Pour créer un nouveau callback cliquer sur le bouton new (en haut à droite)
Choisir l'option **Custom callback**

### Configuration d'un DATA UPLINK

![Data UpLink](/Sigfox/Callback_ruche.PNG)
**Custom payload config :**
Ce champ permet de décoder la trame reçue et de la transmettre au serveur Aggregator. 
```
field1::int:16:little-endian field2::int:16:little-endian field3::int:16:little-endian  field5::uint:16:little-endian field6::int:16:little-endian field4::uint:8 type::uint:8
```
Les données sont renvoyées au serveur Aggregator via  la méthode POST.
```
id={device}&time={time}&data={data}&seqNumber={seqNumber}&field1={customData#field1}&field2={customData#field2}&field3={customData#field3}&field4={customData#field4}&field5={customData#field5}&field6={customData#field6}&type={customData#type}

```

### Configuration d'un service data_advanced

Le service data advanced permet de d'envoyer des informations sur la qualité de la transmission (lqi) et sur la localisation. Ces informations sont codées au format JSON.
 
![Data UpLink](/Sigfox/service data_advanced.PNG)

```
{
  "device" : "{device}",
  "time" : "{time}",
  "data" : "{data}",
  "seqNumber" : "{seqNumber}",
  "lqi" : "{lqi}",
  "operatorName" : "{operatorName}",
  "countryCode": {countryCode},
  "computedLocation" : {computedLocation} 
}
```
### Configuration du service status

Un message de service est envoyé une fois par jour par le modem **sigfox**. Ce message contient la température et la tension d'alimentation. 
![Data UpLink](/Sigfox/service_status.PNG)
```
id={device}&time={time}&seqNumber={seqNumber}&field1={temp}&field2={batt}&type=3&data=Message status
```



## Diagramme de classe Sigfox

![Diagramme de classe](/Sigfox/diagramme_classe.GIF)

### Les méthodes publiques
 - **Sigfox** Le constructeur de l'objet avec en  paramètres  le nom du port série utilisé, **debug** un booléen pour activer le mode débogage.
 - Le constructeur ouvre le port série et fixe le débit de communication à 9600 bauds.
 - **~Sigfox**  le destructeur ferme le port série utilisé. 
 - **tester** Envoie une commande AT sur la liaison série et lit les données entrantes, le module renvoie OK si le transmetteur répond.
 - **obtenirID** Permet d'obtenir l'ID du transmetteur  connecté.
 - **obtenirPAC** Permet d'obtenir le code PAC du transmetteur connecté.
 - **obtenirTemp** Permet d'obtenir la température interne du transmetteur connecté.
 - **envoyer** Envoie un message codé en hexa sur le réseau Sigfox. Un message Sigfox est composé au maximum de 12 octets. Cette méthode attend la fin de l'émission. Elle renvoie  un string OK. Le fait de recevoir la réponse OK ne confirme pas la réception du message par une ou plusieurs stations de base sigfox. 

[le code exemple](https://github.com/PhilippeSimier/Ruche/blob/master/Sigfox/main.cpp)

## Emission des données 

Deux programmes permettent d'envoyer les données vers l'aggrégator 

 - **mesuresSigfox.cpp** pour le suivi des grandeurs relatives à la ruche
 - **batterySigfox.cpp** pour le suivi de la batterie.
 ### Configuration du crontab 
 Le crontab est configuré pour envoyer toute les demi-heures.
 ```
 */30 * * * * /opt/Ruche/bin/mesuresSigfox >/dev/null 2>&1
15,45 * * * * /opt/Ruche/bin/batterySigfox >/dev/null 2>&1
 ```

# Changelog

**09/08/2020 : ** Ajout du README . 

> **Notes :**


> - Licence : **licence publique générale** ![enter image description here](https://img.shields.io/badge/licence-GPL-green.svg)
> - Auteur **Philippe SIMIER** Lycée Touchard Le Mans
>  ![enter image description here](https://img.shields.io/badge/built-passing-green.svg)
<!-- TOOLBOX 

Génération des badges : https://shields.io/
Génération de ce fichier : https://stackedit.io/editor#
example : https://github.com/adrien3d/IO_WSSFM10-Arduino

