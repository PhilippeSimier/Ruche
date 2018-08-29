# The connected Beehive
D’une installation facile et rapide, le système se positionne sous n’importe quelle ruche et délivre en temps réel un suivi précis des grandeurs mesurées, via des vues graphiques sur thing Speak ou sur votre site internet.

En cas de besoin d’intervention, des alertes vous seront transmises par mail, sms, ou notification sur votre smartphone. Ce service est assurée par IFTTT (if this then that).

## Câblage
Réaliser le câblage suivant sur la carte **snir-hat**
![schema cablage HX711](/html/images/snirHat.png)
## Prérequis Installation

Les paquets suivants doivent être installés
```bash
 $ sudo apt install apache2
 $ sudo apt install mysql
 $ sudo apt install php
 $ sudo apt install phpmyadmin
 $ sudo apt install libcurl4-openssl-dev
 $ sudo apt install libmysqlcppconn-dev
```
Configuration de Apache
```bash
$ sudo a2enmod cgi
$ sudo usermod -G video www-data
$ sudo usermod -a -G i2c www-data
$ sudo service apache2 restart
```
Configuration de mysql :

 - création d'une base **data**
 - création d'un utilisateur **ruche** avec mdp **toto**


```bash
$ mysql -u root -p
MariaDB [(none)]> create database data;
MariaDB [(none)]> GRANT ALL PRIVILEGES ON data.* TO ruche@'%' IDENTIFIED BY 'toto';
MariaDB [(none)]> flush privileges;
MariaDB [(none)]> exit
```
 avec phpmyadmin importer le fichier **ruche.sql**
## Installation 
```bash
$ git clone https://github.com/PhilippeSimier/Ruche.git
$ make all
$ make install
$ make clean
```
Configuration **crontab**
ajouter les tâches planifiées suivantes :

 - Exécution de bddLog toutes les 30 minutes;
 - Exécution de thingSpeak toutes les 30 minutes;
 - Exécution de synchronisation toute les 4 heures lorsque minute = 5. 

```bash
*/30 * * * * /home/pi/Ruche/Capteurs/bddLog >> /home/pi/Ruche/activity.log 2>&1
*/30 * * * * /home/pi/Ruche/Capteurs/thingSpeak >> /home/pi/Ruche/activity.log 2>&1
5 */4 * * * /home/pi/Ruche/Capteurs/synchronisation >> /home/pi/Ruche/activity.log 2>&1

```



## Changelog

 **04/08/2018 :** Ajout du README . 
 
> **Notes :**


> - Licence : **licence publique générale** ![enter image description here](https://img.shields.io/badge/licence-GPL-green.svg)
> - Auteur **Philippe SIMIER Lycée Touchard Le Mans**
>  ![enter image description here](https://img.shields.io/badge/built-passing-green.svg)
<!-- TOOLBOX 

Génération des badges : https://shields.io/
Génération de ce fichier : https://stackedit.io/editor#



