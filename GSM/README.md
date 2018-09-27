# Modem GSM

## Test & Installation
Avant de connecter le modem GSM exécuter **lsusb** 
```bash
pi@PI1003:~ $ lsusb
Bus 001 Device 003: ID 0424:ec00 Standard Microsystems Corp. SMSC9512/9514 Fast Ethernet Adapter
Bus 001 Device 002: ID 0424:9512 Standard Microsystems Corp. LAN9500 Ethernet 10/100 Adapter / SMSC9512/9514 Hub
Bus 001 Device 001: ID 1d6b:0002 Linux Foundation 2.0 root hub
```
Connecter le modem sur la prise USB puis relancer la commande **lsusb**
```bash
pi@PI1003:~ $ lsusb
Bus 001 Device 004: ID 0403:6010 Future Technology Devices International, Ltd FT2232C Dual USB-UART/FIFO IC
Bus 001 Device 003: ID 0424:ec00 Standard Microsystems Corp. SMSC9512/9514 Fast Ethernet Adapter
Bus 001 Device 002: ID 0424:9512 Standard Microsystems Corp. LAN9500 Ethernet 10/100 Adapter / SMSC9512/9514 Hub
Bus 001 Device 001: ID 1d6b:0002 Linux Foundation 2.0 root hub
```
Un composant supplémentaire doit apparaître: 
**Device 004: ID 0403:6010**  c'est un dual USB-UART/FIFO

Listez les devices ttyUSB
```bash
pi@PI1003:~ $ ls /dev/ttyUSB*
/dev/ttyUSB0  /dev/ttyUSB1
```


## Installation de minicom
**Minicom** est un programme de contrôle de modem.

ligne de commande pour installer :
```bash
pi@PI1003:~ $ sudo apt-get install minicom
```
## Configuration de minicom

```bash
pi@PI1003:~ $ sudo minicom -s
```
Une fenêtre de configuration apparaît pour configurer les paramètres de la communication.
```bash
            +-----[configuration]------+
            | Filenames and paths      |
            | File transfer protocols  |
            | Serial port setup        |
            | Modem and dialing        |
            | Screen and keyboard      |
            | Save setup as dfl        |
            | Save setup as..          |
            | Exit                     |
            | Exit from Minicom        |
            +--------------------------+
```
Sélectionner **Serial port setup** avec les flèches bas et haut du clavier
```bash
    +-----------------------------------------------------------------+
    | A -    Serial Device      : /dev/ttyUSB0                        |
    | B - Lockfile Location     : /var/lock                           |
    | C -   Callin Program      :                                     |
    | D -  Callout Program      :                                     |
    | E -    Bps/Par/Bits       : 115200 8N1                          |
    | F - Hardware Flow Control : No                                  |
    | G - Software Flow Control : No                                  |
    |                                                                 |
    |    Change which setting?                                        |
    +-----------------------------------------------------------------+
            | Screen and keyboard      |
            | Save setup as dfl        |
            | Save setup as..          |
            | Exit                     |
            | Exit from Minicom        |
            +--------------------------+
```
Sélectionner **Bps/Par/Bits** en appuyant sur la touche E, pour régler la vitesse de transmission sur **115200** bauds, **8**bits par caractère, **pas de parité**, **un bit de stop**.  
Configurer l'option **Hardware Flow Control**  sur **No** et **Software Flow Control**  sur **No**

Ensuite sélectionner **Screen and keyboard**

              +-----------------[Screen and keyboard]-----------------+
              | A - Command key is         : ^A                       |
              | B - Backspace key sends    : BS                       |
              | C - Status line is         : enabled                  |
              | D - Alarm sound            : Yes                      |
              | E - Foreground Color (menu): WHITE                    |
              | F - Background Color (menu): BLACK                    |
              | G - Foreground Color (term): WHITE                    |
            +-| H - Background Color (term): BLACK                    |
            | | I - Foreground Color (stat): WHITE                    |
            | | J - Background Color (stat): BLACK                    |
            | | K - History Buffer Size    : 2000                     |
            | | L - Macros file            : .macros                  |
            | | M - Edit Macros                                       |
            | | N - Macros enabled         : Yes                      |
            | | O - Character conversion   :                          |
            | | P - Add linefeed           : No                       |
            | | Q - Local echo             : No                       |
            +-| R - Line Wrap              : No                       |
              | S - Hex Display            : No                       |
              | T - Add carriage return    : No                       |
              |  Change which setting?  (Esc to exit)                 |
              +-------------------------------------------------------+
Dans ce menu vous devez définir un echo local sur No (le modem GSM retourne un echo des caratères reçus).


Sortir du mode de configuration avec **"Save setup as dfl"**
Cela va enregistrer la configuration dans un fichier: /etc/minicom/minirc.dfl 

## Quitter minicom
Pour quitter minicom taper au clavier

 - Ctrl A
 - Z   (pour obtenir l'aide)
 - Q  (pour quitter)

## Exécuter minicom
```
pi@PI1003:~ $ sudo minicom -D /dev/ttyUSB0

Welcome to minicom 2.7

OPTIONS: I18n 
Compiled on May  7 2017, 05:18:49.
Port /dev/ttyUSB0, 10:58:00

Press CTRL-A Z for help on special keys

```
envoyer at
le modem doit répondre OK

## Envoyer un SMS

A la première sous tension du modem le code pin doit être entré. Pour ce faire saisir la commande at suivante :
```
AT+CPIN=0000
+CPIN: READY

OK

Call Ready
```
le modem répond **OK** puis un instant plus tard **Call Ready**

Passage en mode texte 
```
AT+CMGF=1                                                                                                        
OK
```
Envoyer un message SMS saisir la commande AT+CMGS="0689744200" puis enter
le modem répond en affichant le prompt > saisir le message enter pour passer à la ligne, puis ctrl Z  pour envoyer. (terminés par Ctrl+Z, 0x1A, 26). Le modem répond alors =CMGS: 252 puis OK.
```
AT+CMGS="0689744236"                                                                                             
> mon premier message SMS avec le modem GSM                                                                     
>                                                                                                                
+CMGS: 252                                                                                                       
                                                                                                                 
OK
```




 
 



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



