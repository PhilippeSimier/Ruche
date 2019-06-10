# Authentification SSH par clés

## Introduction

L’authentification sur un serveur à l’aide d’une clé publique / privée a l'avantage de permettre de **se connecter au serveur sans utiliser de mot de passe**. Cela est indispensable si l'on souhaite copier un fichier avec scp sur le serveur à partir d'un script. 

## 1 Création des clés

Dans un premier temps, il est nécessaire en tant qu'utilisateur root de créer une clé publique privée sur sa machine en utilisant la commande **ssh-keygen** :
```bash
root@pi3PSR:/home/pi# cd ~
root@pi3PSR:~#  ssh-keygen -t rsa -b 2048
Generating public/private rsa key pair.
Enter file in which to save the key (/root/.ssh/id_rsa):[enter]
Created directory '/root/.ssh'.
Enter passphrase (empty for no passphrase):[enter]
Enter same passphrase again:[enter]
Your identification has been saved in /root/.ssh/id_rsa.
Your public key has been saved in /root/.ssh/id_rsa.pub.
The key fingerprint is:
SHA256:hQZDt5wN4dDRquFINWtskO53l3zAZ5ffLGiJbUWz6tA root@pi3PSR
The key's randomart image is:
+---[RSA 2048]----+
|     o=.=+       |
|    o oB.*.   o  |
|   . + oBoo  . + |
|    o *...o o =  |
|   o = oS. O * o.|
|    o + . * E . +|
|     . . . *   . |
|            .    |
|                 |
+----[SHA256]-----+
```
La commande demandera ou installer la clé privée, laissez l’emplacement par défaut à savoir  **/root/.ssh/id_rsa**
la commande va ensuite nous proposer de saisir une passphrase, entrer directement enter puis confirmer par enter.
Une fois créées, vous pourrez donc voir vos clés dans le répertoire "**.ssh**" de l'utilisateur root.

```bash
root@pi3PSR:~# ls -al .ssh
total 16
drwx------ 2 root root 4096 juin  10 16:33 .
drwx------ 8 root root 4096 juin  10 16:33 ..
-rw------- 1 root root 1679 juin  10 16:33 id_rsa
-rw-r--r-- 1 root root  393 juin  10 16:33 id_rsa.pub
```
Visualisation de la clé publique
```bash
root@pi3PSR:~# cd .ssh
root@pi3PSR:~/.ssh# more id_rsa.pub
ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQC5p7K7SdizMG9OgMZg777jy87V9jkQnnbFZDPwP1Fw
/zEWZ2xd7sMOOoU8IVHoIk9Pm2LqOGQSVNgQj8FqDz5TWF3Nb+ucFoZIkPt+0T/G4YfLTbdHp69bJU4n
Uzhx6qGlhNryS7wPKNyQyC4pqeKr6tzNBUbPYRA1bL2ONhf16nqY/8Ah9H/Kcyo6bIkZPCjU7kaZFa/z
d1PV11GOzgb2WBD2FPt/AidZIBsV1clrfhYBhC5RbOTXq9eYGA4s9/bOmGdJ9rz0B6HIq3XIOAhoDEWq
aRxFJZTctxUTlONE0otnaRtflAsiRoWucmTR67Tn65CEebFHEaSEqdt4XrfT  root@pi3PSR 
```
## Copie de la clé publique sur le serveur
Afin de pouvoir utiliser cette clé pour s’authentifier au serveur souhaité, il est nécessaire de la copier dans les clés autorisées du compte utilisateur root sur le serveur.
Pour ce faire :
```bash
root@pi3PSR:~# cat ~/.ssh/id_rsa.pub | ssh root@172.18.58.9 "cat - >> ~/.ssh/authorized_keys"
password:
```
NB2 : Il est à noter que les clés sont valables pour une machine et un utilisateur particulier.

## Tests
Connexion sur 172.18.58.9 en tant que root à partir de pi3PSR
```bash
root@pi3PSR:~#  ssh -i /root/.ssh/id_rsa 172.18.58.9
```
Copie de fichiers :
```bash
 root@pi3PSR:~# /var/tmp/ram_drive/scp cam.jpg root@172.18.58.9:/var/www/Ruche/video
```
### Changelog

 **10/06/2019 :** Ajout de Authentification SSH par clés . 
 
 
> **Notes :**


> - Licence : **licence publique générale** ![enter image description here](https://img.shields.io/badge/licence-GPL-green.svg)
> - Auteur **Philippe SIMIER Lycée Touchard Le Mans**
>  ![enter image description here](https://img.shields.io/badge/built-passing-green.svg)
<!-- TOOLBOX 

Génération des badges : https://shields.io/
Génération de ce fichier : https://stackedit.io/editor#
https://docplayer.fr/15188945-Le-traitement-d-images-avec-opencv.html

