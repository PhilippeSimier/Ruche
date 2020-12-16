#  Limiter la consommation du Raspberry PI

Limiter la consommation d’un Raspberry pi en gardant un niveau de performance acceptable pour l’utilisation sur batterie avec panneau solaire.

##  Désactiver la carte son embarquée:

Vérifier la présence de la carte son avec la commande **aplay -l**

    root@oize:/etc/modprobe.d# aplay -l
    **** Liste des Périphériques Matériels PLAYBACK ****
    carte 0: Headphones [bcm2835 Headphones], périphérique 0: bcm2835 Headphones [bcm2835 Headphones]
      Sous-périphériques: 8/8
      Sous-périphérique #0: subdevice #0
      Sous-périphérique #1: subdevice #1
      Sous-périphérique #2: subdevice #2
      Sous-périphérique #3: subdevice #3
      Sous-périphérique #4: subdevice #4
      Sous-périphérique #5: subdevice #5
      Sous-périphérique #6: subdevice #6
      Sous-périphérique #7: subdevice #7
      
Créez un fichier **alsa-blacklist.conf** à l'aide de nano et enregistrez-le dans /etc/modprobe.d

    sudo nano /etc/modprobe.d/alsa-blacklist.conf

Ajouter la ligne suivante :

    blacklist snd_bcm2835
Redémarrer **reboot**
Vérifier l'absence de la prise en compte

    root@oize:/home/pi# aplay -l
    aplay: device_list:272: aucune carte son n'a été trouvée...


## Faire fonctionner le raspberry à une cadence un peu moins élevée:

Raspbian fixe la fréquence du processeur à 700 MHz par défaut.  Il ne serait pas raisonnable de conserver la fréquence maximale du processeur pour l'utilisation qui ne nécessite pas à tout moment la pleine puissance du processeur.

Le fichier **/boot/config.txt** est lu par le GPU pour la configuration matérielle avant que le CPU ne soit activé. 
Cela inclut le réglage de la fréquence  du cpu .  
Editer le fichier **config.txt**

    sudo nano  /boot/config.txt
Ajouter les lignes suivantes :

    force_turbo=0
    arm_freq=700
    arm_freq_min=100
**force_turbo = 0**  signifie «activer la mise à l'échelle de la fréquence du processeur»
  **arm_freq_min = 100**  Définit la fréquence cpu la plus basse. Par défaut, elle est de 700. 

## Désactiver la sortie HDMI:

tvservice -o désactive tout le pipeline d'affichage, y compris les horloges, le matériel vidéo Scaler, Pixel Valve, récupère les couches d'affichage de sdram, etc.

    sudo nano /etc/rc.local
Ajouter la ligne suivante :

    /opt/vc/bin/tvservice -o

## Activer la gestion de l’énergie à la demande:

Le noyau Linux a un pilote qui gère la politique de fréquence du processeur.  L'option suivante est disponible pour cela.

 - **performances** - utilise toujours la fréquence maximale du processeur  
 - **powersave** - utilise toujours la fréquence mini du processeur
 - **ondemand** - change la fréquence du processeur en fonction de la charge du processeur (sur rasbian, commute juste le min et le max)
 - **conservative** - change en douceur la fréquence du processeur en fonction de la charge du processeur

 Rasbian a défini **powersave** par défaut.

Mettez la commande dans /etc/rc.local.  L'exécution de la commande a lieu après le démarrage du noyau. Donc, cela ralentit le démarrage.

    sudo nano /etc/rc.local
Ajouter la ligne suivante

    cpufreq-set -g conservative
Connaitre la fréquence du CPU

    vcgencmd measure_clock arm 


## Changelog

 
 **15/12/2020 :** Ajout choix du panneau solaire photovoltaïque
 
> **Notes :**


> - Licence : **licence publique générale** ![enter image description here](https://img.shields.io/badge/licence-GPL-green.svg)
> - Auteur **Philippe SIMIER Lycée Touchard Le Mans**
>  ![enter image description here](https://img.shields.io/badge/built-passing-green.svg)
<!-- TOOLBOX 

Génération des badges : https://shields.io/
Génération de ce fichier : https://stackedit.io/app#
