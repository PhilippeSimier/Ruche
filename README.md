# The connected Beehive 
D’une installation facile et rapide, le système se positionne sous n’importe quelle ruche et délivre en temps réel un suivi précis des grandeurs mesurées.  Si la connexion réseau est présente, les grandeurs mesurées sont stokées sur la plate forme Thing Speak,  dans le cas contraire, les mesures sont enregistrées localement dans une base de données. Les mesures peuvent être consultées via des vues graphiques sur un site WEB.

**ThingSpeak** est une API et une application open source pour l'« Internet des objets », permettant de stocker et de collecter les données des objets connectés en passant par le protocole HTTP via Internet. Les données collectées peuvent être analysées avec des programmes MATLAB. On peut ainsi tracer des diagrammes de corrélation, effectuer des statistiques (calcul de moyenne mini maxi etc...

En cas de besoin d’intervention, des alertes sont transmises par mail ou sms sur  smartphone. Ce service est assurée par une API sur la Gateway.



## Câblage du Système de mesure
Réaliser le câblage suivant sur la carte **snir-hat**
![schema cablage HX711](/html/images/snirHat.png)
 
## Prérequis Installation

sous strectch Les paquets suivants doivent être installés 

 1. apache2
 2. mysql
 3. php
 4. php7.0-curl
 4. phpmyadmin
 5. libcurl4-openssl-dev
 6. libmysqlcppconn-dev

si vous êtes sous **Jessy** installer le paquet suivant
 - php5-curl

Configuration de Apache

 1. Activer le module cgi
 2. Activer le module rewrite
 2. ajouter www-data au groupe video et i2c
 
Vous pouvez utiliser le script shell **RaspbianOSsetup.sh** pour installer les packages requis et configurer Apache. 
```bash
~ $ git clone https://github.com/PhilippeSimier/Ruche.git
~ $ cd Ruche/
~/Ruche $ ./Raspbian_OS_Setup/RaspbianOSsetup.sh
```
## Création de la base de données data

 - création d'une base **data**
 - création d'un utilisateur **ruche** avec mdp **toto**
 - création des tables users, things, channels et feeds
 
Vous pouvez  en tant que **root** utiliser le script shell **mysql_data_setup** pour installer la base de données  et créer l'utilisateur 'ruche' requis.

```bash
/home/pi/Ruche# ./Raspbian_OS_Setup/mysql_Data_setup
```
 
## Compilation & installation 

 **make  all** 
```bash
~/Ruche $ cd Capteurs
~/Ruche/Capteurs $ make all
~/Ruche/Capteurs $ make install
~/Ruche/Capteurs $ make clean
```
Installation des exécutables

**make install**

Installation des fichiers de configurations

**make config**

## Thing Speak

Pour pouvoir télécharger les données sur ThingSpeak à des fins d'analyse et de traitement, vous devez créer un compte.

Une fois le compte créé, vous devez créer un nouveau canal en lui donnant un nom.
Les champs reflètent les données que vous allez télécharger.  
Vous devez définir les champs  comme sur la figure ci-dessous. 
![Canaux Thing Speak](/Canal_Thing_Speak.png)

À l'issue de cette opération, cliquez sur Enregistrer le canal.  Vous êtes maintenant prêt à télécharger les données de la ruche vers son canal correspondant.

Recherchez la clé API correspondant à votre canal (Write API Key).
À chaque canal correspondra une clé API unique, destinée à garantir le téléchargement des données au bon emplacement.

Veuillez à mémoriser la clé API **Write API Key** . Vous l'utiliserez comme argument des tâches thingSpeak qui seront exécutées à interval régulier par le processus cron.

## Configuration **crontab**
ajouter les tâches planifiées suivantes :

 - Exécution de **bddLog** toutes les 30 minutes;
 - Exécution de **thingSpeak** toutes les 30 minutes;
 - Exécution de **synchronisation** toute les 4 heures lorsque l'aiguille des minutes est sur 5. 

```bash
/home/pi/Ruche# crontab -e

*/30 * * * * /home/pi/Ruche/Capteurs/bddLog >> /home/pi/Ruche/activity.log 2>&1
*/30 * * * * /home/pi/Ruche/Capteurs/thingSpeak >> /home/pi/Ruche/activity.log 2>&1
5 */4 * * * /home/pi/Ruche/Capteurs/synchronisation >> /home/pi/Ruche/activity.log 2>&1

```
## Configuration et Etalonnage de la **balance**

La balance doit être étalonnée. Cette procédure consiste à prendre un poids connu (p. ex. 5 kg) et d'établir la relation pour que la valeur affichée à l'écran corresponde à la valeur connue.
Le programme **etalonnage** permet de déterminer les paramètres de cette relation et de les enregistrer dans le fichier **configuration.ini**.
Pour ce faire, en mode console lancer le programme **etalonnage**
```bash
~/Ruche $ cd Capteurs/
~/Ruche/Capteurs $ ./etalonnage
Quelle est l'unité de mesure ? (g kg lb)
kg
Quelle est la précision d'affichage : 1 ou 2 chiffres après la virgule
2
Donnez le gain souhaité : 128 ou 64 ? 
64

```
Répondez aux différentes questions, le programme va ensuite lancer la procédure de tarage, puis va vous demandez de placer un poids étalon sur le plateau de la balance.  Vous devez donner sa valeur. Le programme continue alors sa procédure.

Sans retirer le poids étalon lancer le programme testBalance
```bash
~/Ruche/Capteurs $ ./testBalance
* 15.00
```
Vous devriez voir s'afficher sur l'écran la valeur du poids étalon.
La configuration de la balance est terminée.

## Test des capteurs BME280 et BH1750
Le test de fonctionnement du capteur BME280 peut être effectué en exécutant le programme : **testBME280**
```bash
~/Ruche/Capteurs $ ./testBME280 
Capteur BME 280 présent sur le bus I2C
 Température (C)  : 28.0 °C
 Température (F)  : 82.5 °F
 Pression         : 1018.9 hPa
 Humidité         : 42.3 %
 Pression P0      : 1023.7 hPa
 Point de rosée   : 14.0 °C

```
Le test de fonctionnement du capteur BH1750 peut être effectué en exécutant le programme : **testBH1750**

```bash
~/Ruche/Capteurs $ ./testBH1750
Capteur d'éclairement
Eclairement : 222.9 lx
Eclairement : 222.9 lx
Eclairement : 222.9 lx
^C
```
 
 

## Site Web

Dans un navigateur web ouvrir l'url suivante: 
http://adresse_IP_du_raspberry


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



