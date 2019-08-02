# Gammu-smsd  avec MySQL


## Installation de la base smsd

Avec phpmyadmin créer une base de données  **smsd**.
Créer les tables en important le fichier mysql.sql enregistré dans le répertoire  /usr/share/doc/gammu-smsd/examples/
```bash
root@raspberrypi3:~# cd /usr/share/doc/gammu-smsd/examples/
root@raspberrypi3:/usr/share/doc/gammu-smsd/examples# gunzip mysql.sql.gz
root@raspberrypi3:/usr/share/doc/gammu-smsd/examples# ls -l
total 16
-rw-r--r-- 1 root root 8174 mai   29  2013 mysql.sql
-rw-r--r-- 1 root root 1546 mai   29  2013 pgsql.sql.gz
-rw-r--r-- 1 root root  993 mai   29  2013 sqlite.sql.gz
```

## Configuration de Gammu-smsd

gammu-smsd lit la configuration à partir d'un fichier de configuration. Son emplacement peut être spécifié sur la ligne de commande (option -c), sinon le fichier par défaut **/etc/gammu-smsdrc** est utilisé.

La section **[gammu]** est la configuration d'une connexion au modem GSM
la section **[smsd]** configure le démon SMS lui-même.
Le paramètre **pin**  est facultatif, mais vous devez le définir si votre carte SIM après la mise sous tension nécessite un code PIN.

Exemple de fichier de configuration :
```
# Configuration file for Gammu SMS Daemon

[gammu]

port = /dev/ttyUSB0
connection = at
GammuLoc = fr_FR.UTF8
gammucoding = utf8

[smsd]
service = sql
driver = native_mysql
host = localhost
user = ruche
password = touchard72
database = smsd

logfile = syslog
# Increase for debugging information
debuglevel = 0
RunOnReceive = /home/pi/Ruche/SMSDreceive.sh
pin = 0000

```


## Démarrer le démon smsd

```bash
pi@raspberrypi3:/etc $ sudo service gammu-smsd start

```


## Vérifier l'état du démon gammu_smsd
```bash
root@raspberrypi3:~# sudo service gammu-smsd status
● gammu-smsd.service - LSB: Gammu SMS daemon
   Loaded: loaded (/etc/init.d/gammu-smsd)
   Active: active (running) since ven. 2019-08-02 11:05:06 CEST; 4s ago
  Process: 14701 ExecStop=/etc/init.d/gammu-smsd stop (code=exited, status=0/SUCCESS)
  Process: 14845 ExecStart=/etc/init.d/gammu-smsd start (code=exited, status=0/SUCCESS)
   CGroup: /system.slice/gammu-smsd.service
           └─14850 /usr/bin/gammu-smsd --daemon --user gammu --pid /var/run/gammu-smsd.pid

août 02 11:05:06 raspberrypi3 gammu-smsd[14850]: Connected to Database: smsd on localhost
août 02 11:05:06 raspberrypi3 gammu-smsd[14850]: Execute SQL: SELECT  `ID` FROM outbox LIMIT 1
août 02 11:05:06 raspberrypi3 gammu-smsd[14850]: Execute SQL: SELECT  `ID` FROM outbox_multipart LIMIT 1
août 02 11:05:06 raspberrypi3 gammu-smsd[14850]: Execute SQL: SELECT  `ID` FROM sentitems LIMIT 1
août 02 11:05:06 raspberrypi3 gammu-smsd[14850]: Execute SQL: SELECT  `ID` FROM inbox LIMIT 1
août 02 11:05:06 raspberrypi3 gammu-smsd[14850]: Execute SQL: SELECT `Version` FROM gammu
août 02 11:05:06 raspberrypi3 gammu-smsd[14850]: Database structures version: 13, SMSD current version: 13
août 02 11:05:06 raspberrypi3 gammu-smsd[14850]: Connected to Database native_mysql: smsd on localhost
août 02 11:05:06 raspberrypi3 gammu-smsd[14850]: Created POSIX RW shared memory at 0x76f2c000
août 02 11:05:06 raspberrypi3 gammu-smsd[14850]: Starting phone communication...
```
Le démon fonctionne correctement si la ligne Starting phone communication est affichée. Dans le cas contraire il y a peut être un problème de version !

## Envoyer un SMS 

**gammu-smsd-inject** est un programme qui **met en file d'attente le message** , qui sera ensuite envoyé par le démon à l'aide du modem GSM connecté.

Injecter un **message texte** jusqu'à 160 caractères standard:
```bash
root@raspberrypi3:/usr/share/doc/gammu-smsd/examples# gammu-smsd-inject TEXT 0689744235 -text "Nous sommes le `date`"
gammu-smsd-inject[14265]: Connected to Database: smsd on localhost
gammu-smsd-inject[14265]: Connected to Database native_mysql: smsd on localhost
gammu-smsd-inject[14265]: Written message with ID 1
Written message with ID 1

```


## Changelog

 **02/08/2019 :** Ajout gammu-smsd avec mysql  
 
 
> **Notes :**


> - Licence : **licence publique générale** ![enter image description here](https://img.shields.io/badge/licence-GPL-green.svg)
> - Auteur **Philippe SIMIER Lycée Touchard Le Mans**
>  ![enter image description here](https://img.shields.io/badge/built-passing-green.svg)
<!-- TOOLBOX 

Génération des badges : https://shields.io/
Génération de ce fichier : https://stackedit.io/editor#




