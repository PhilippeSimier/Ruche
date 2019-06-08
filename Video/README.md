# Webcam

Une caméra est installée pour surveiller le flux entrant et sortant des abeilles. L'idée est simple. Nous allons capturer des images toutes les **3 secondes** et les partager via une interface Web ce qui nous permettra de voir à distance  virevolter les abeilles . Pour la capture, nous utiliserons l'utilitaire  de console **raspistill**  fourni avec RASPBIAN.  

### 1 Configuration d'une partition mémoire en RAM 

Étant donné que toute carte SD a des ressources limitées pour les cycles d'écriture, nous allons  créer une « partition » directement dans la RAM qui est spécialement conçue pour encaisser de nombreux cycles d’écritures. Nous utiliserons ce lecteur ram en tant que lecteur de stockage temporaire pour enregistrer les images. 

Commençons par créer un dossier pour cela:
```
root@raspPi3plus:/home/pi# mkdir /var/tmp/ram_drive
```
Il convient d’éditer le fichier /etc/fstab qui gère les points de montages du système. 
```
root@raspPi3plus:/home/pi# nano /etc/fstab
```
Ajouter la ligne suivante :
```
proc                  /proc       proc    defaults          0       0
PARTUUID=f0fb3126-01  /boot      vfat    defaults          0       2
PARTUUID=f0fb3126-02  /          ext4    defaults,noatime  0       1
tmpfs      /var/tmp/ram_drive tmpfs nodev,nosuid,size=10M 0 0
```
Maintenant montez le  système:
```
root@raspPi3plus:/home/pi# sudo mount -a
```
Vérifiez le montage:
```
root@raspPi3plus:/home/pi# df -h
Sys. de fichiers Taille Utilisé Dispo Uti% Monté sur
/dev/root           15G    9,7G  4,2G  70% /
devtmpfs           434M       0  434M   0% /dev
tmpfs              438M       0  438M   0% /dev/shm
tmpfs              438M     39M  400M   9% /run
tmpfs              5,0M    4,0K  5,0M   1% /run/lock
tmpfs              438M       0  438M   0% /sys/fs/cgroup
/dev/mmcblk0p1      43M     23M   21M  52% /boot
tmpfs               88M       0   88M   0% /run/user/1000
tmpfs               10M    724K  9,3M   8% /var/tmp/ram_drive

```
### 2 Script bash pour capturer des images

Nous allons créer un script qui sera lancé par le démon cron toutes les minutes. 
la période d'une minute ne suffit pas, nous avons besoin d'actualiser l'image toutes les 3 secondes. La solution est d'exécutée raspistill 20 fois dans le processus (60/20 = 3 secondes).
les images capturées sont  recopiées dans le répertoire vidéo sur le site WEB de la DMZ avec la commande **scp** (Secure copy). La commande scp permet de transférer des fichiers entre deux ordinateurs en utilisant le protocole de communication SSH. 
Pour ne pas demandé le mot de passe le serveur WEB  DMZ doit connaître la clé publique de la raspberry pi. Cette clé doit  être présente dans le fichier ~/.ssh/authorized_keys. 

```bash
#!/bin/bash

OUTPUT=/var/tmp/ram_drive

for i in `seq 1 19 `
do
  echo "image $i"
  raspistill -a 4 -a "%d %B %Y %X" -ae 32,0xFF,0x000080 -t 1000 -w 1296 -h 972  -o $OUTPUT/cam.jpg
  scp $OUTPUT/cam.jpg root@172.18.58.9:/var/www/Ruche/video
  sleep 1
done
``` 

### Page Web

Créons une page Web qui actualisera l’image toutes les 3 secondes.
```
 <body>
	<?php require_once 'menu.php'; ?>
	<div class="container" style="padding-top: 65px;">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div >
			        <img src="" class="popin d-block mx-auto img-fluid"  id="photo" alt="Beehive on air" />
					
			    </div>  
				
			</div>
		</div>
		<?php require_once 'piedDePage.php'; ?>
	</div>

</body>
```
Le script qui réactualise l'image à l'écran.

```javascript
<script type="text/javascript">
"use strict";
function affiche(){
            var img = document.getElementById("photo");
            img.src = 'http://touchardinforeseau.servehttp.com/Ruche/video/cam.jpg?'+new Date().getMilliseconds();
		    console.log("rafraichissement : " + img.src);	
		}
		
 $(document).ready(function(){
				
   	affiche();
	setInterval(affiche, 3002);       // appel de la fonction affiche toutes les 3 secondes et 2 milliemes
});
</script>
```

### Changelog

 **07/06/2019 :** Ajout du README . 
 
 
> **Notes :**


> - Licence : **licence publique générale** ![enter image description here](https://img.shields.io/badge/licence-GPL-green.svg)
> - Auteur **Philippe SIMIER Lycée Touchard Le Mans**
>  ![enter image description here](https://img.shields.io/badge/built-passing-green.svg)
<!-- TOOLBOX 

Génération des badges : https://shields.io/
Génération de ce fichier : https://stackedit.io/editor#
https://docplayer.fr/15188945-Le-traitement-d-images-avec-opencv.html

