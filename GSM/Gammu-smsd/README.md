# Gammu-smsd

**gammu-smsd** est un programme daemon qui se charge de recevoir et d'envoyer les SMS. Pour ce faire il analyse périodiquement le modem GSM pour lire les SMS reçus et les stocker dans un répertoire défini. Il envoie les SMS placés dans le répertoire des SMS à envoyer.

***Attention*** vous ne pouvez pas exécuter Gammu et Gammu-SMSD en même temps sur le même modem GSM, cependant vous pouvez contourner cette limitation en suspendant temporairement SMSD en utilisant les signaux SIGUSR1 et SIGUSR2.

 - **SIGUSR1** Suspend  SMSD, en fermant la connexion au modem GSM
 - **SIGUSR2** Reprend  SMSD (après la suspension précédente).



## Installation
```bash
pi@raspberrypi3:~ $ sudo apt-get install gammu-smsd
pi@raspberrypi3:~ $ gammu-smsd -v
Gammu-smsd version 1.33.0

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
service = files
logfile = syslog
# Increase for debugging information
debuglevel = 0
RunOnReceive = /home/pi/Ruche/SMSDreceive.sh
pin = 0000

# Paths where messages are stored
inboxpath = /var/spool/gammu/inbox/
outboxpath = /var/spool/gammu/outbox/
sentsmspath = /var/spool/gammu/sent/
errorsmspath = /var/spool/gammu/error/
```
Le répertoire **/var/spool/gammu/inbox/** contient les SMS reçus. Chaque SMS reçu est mémorisé dans un fichier texte. Le nom du fichier est composé de la date de réception suivi du numéro de téléphone expéditeur.  Exemple : **IN20180929_220922_00_+33689744236_00.txt**

Le répertoire  /var/spool/gammu/sent/ contient les SMS émis. Chaque SMS émis est mémorisé dans un fichier texte.  Exemple :
**OUTC20180930_181847_00_0689744235_sms0.smsbackup**


## Démarrer le démon smsd

```bash
pi@raspberrypi3:/etc $ sudo service gammu-smsd start
```

## Stoper le démon smsd
```bash
pi@raspberrypi3:/etc $ sudo service gammu-smsd stop
```

## Redémarrer le démon smsd
```bash
pi@raspberrypi3:/etc $ sudo service gammu-smsd stop restart 
```


## Vérifier l'état du démon gammu_smsd
```bash
pi@raspberrypi3:~ $ sudo service gammu-smsd status
● gammu-smsd.service - LSB: Gammu SMS daemon
   Loaded: loaded (/etc/init.d/gammu-smsd)
   Active: active (exited) since dim. 2018-09-30 17:50:35 CEST; 8min ago

sept. 30 17:50:35 raspberrypi3 gammu-smsd[29650]: gammu-smsd not yet configured, please...).
sept. 30 17:50:35 raspberrypi3 systemd[1]: Started LSB: Gammu SMS daemon.
Hint: Some lines were ellipsized, use -l to show in full.

```

## Envoyer un SMS 

**gammu-smsd-inject** est un programme qui **met en file d'attente le message** , qui sera ensuite envoyé par le démon à l'aide du modem GSM connecté.

Injecter un **message texte** jusqu'à 160 caractères standard:
```bash
root@raspberrypi3:/# gammu-smsd-inject TEXT 0689744236 -text "Nous sommes le `date`"
gammu-smsd-inject[3314]: Created outbox message OUTC20180930_193115_00_0689744236_sms0.smsbackup
Written message with ID /var/spool/gammu/outbox/OUTC20180930_193115_00_0689744236_sms0.smsbackup

```
Injecter un **message texte Unicode**: 
```bash
root@raspberrypi3:/home/pi# gammu-smsd-inject TEXT 0689744236 -unicode -text "Zkouška sirén été Anaïs"
```

Injecter le contenu d'un **fichier text** :
Le contenu d'un fichier texte peut être envoyé sur l'entrée standard de gammu-smsd-inject. 
```bash
root@raspberrypi3:/home/pi/# cat textSMS | gammu-smsd-inject TEXT 0689744235 -unicode -len 400
```

## Recevoir un SMS et effectuer un traitement

Chaque fois que SMSD reçoit un message et le stocke dans le service backend, il peut lancer l'exécution de votre propre programme pour effectuer tout traitement sur le message reçu.

Exemple  de script: 
pi@raspberrypi3:~# nano /home/pi/Ruche/SMSDreceive.sh
```bash
#!/bin/sh
# script exécuter par le démon Gammu lors de la reception d'un SMS
# variables d'environnement
# SMS_1_CLASS
# SMS_1_NUMBER= numero tel
# SMS_1_TEXT= message
# SMS_MESSAGES = le nbre de SMS reçus
# en argument le fichier contenant le SMS

echo "---------------------------------------" >> /home/pi/Ruche/sms.log
echo "$(date) : $SMS_MESSAGES  SMS(s) recu(s)" >> /home/pi/Ruche/sms.log
echo "from : $SMS_1_NUMBER" >> /home/pi/Ruche/sms.log
echo "message : $SMS_1_TEXT" >> /home/pi/Ruche/sms.log
echo "fichier contenant le SMS : $1" >> /home/pi/Ruche/sms.log

exit 0

```
**Attention** Le script doit être exécutable par **gammu**,  il doit donc être exécutable, +x,  il doit avoir pour propriétaire gammu et appartenir au groupe gammu.
Ne pas oublier d'ouvrir les droits en écriture pour de répertoire Ruche.
```bash
pi@raspberrypi3:~/Ruche $ chmod +x SMSDreceive.sh
pi@raspberrypi3:~/Ruche $ sudo chown gammu SMSDreceive.sh
pi@raspberrypi3:~/Ruche $ sudo chgrp gammu SMSDreceive.sh
pi@raspberrypi3:~/Ruche $ ls -l
total 4
-rwxr-xr-x 1 gammu gammu 578 oct.   6 11:10 SMSDreceive.sh
pi@raspberrypi3:~ $ cd ..
pi@raspberrypi3:~ $ chmod 777 Ruche/

```

[Plus d'infos sur le site officiel GAMMU](https://wammu.eu/docs/manual/smsd/run.html)

## Envoyer un SMS depuis un script php

```php
<?php

    $ligne  = "gammu-smsd-inject TEXT 0612345678 -text \"Test de l'envoi SMS avec API\"";
    $output = shell_exec($ligne);
    echo "<p>output : </p><pre>" . $output . "</pr>";
?>
```
L’utilisateur apache (www-data) doit avoir accès à  /dev/ttyUSB0
Pour ce faire ajouter **www-data** au groupe **dialout**
```bash
    sudo usermod -a -G dialout www-data
```
www-data doit pouvoir exécuter gammu-smsd-inject avec les droits du propriétaire  :    *chmod +s*
```bash
root@raspberrypi3:/home/pi# chmod 4755 gammu-smsd-inject
``` 

## Obtenir le niveau du signal

```bash
pi@raspberrypi3:~ $ sudo gammu-smsd-monitor -n 1 -d 1 | grep NetworkSignal
NetworkSignal: 60
```

## Obtenir l'IMEI
L'imei est un numéro permettant d'identifier de manière unique un modem GSM.
```bash
pi@PI1003:~ $ sudo gammu-smsd-monitor -n 1 -d 1 | grep IMEI
IMEI: 863071014745125

```


## Changelog

 **30/09/2018 :** Ajout du README . 
 
 
> **Notes :**


> - Licence : **licence publique générale** ![enter image description here](https://img.shields.io/badge/licence-GPL-green.svg)
> - Auteur **Philippe SIMIER Lycée Touchard Le Mans**
>  ![enter image description here](https://img.shields.io/badge/built-passing-green.svg)
<!-- TOOLBOX 

Génération des badges : https://shields.io/
Génération de ce fichier : https://stackedit.io/editor#



