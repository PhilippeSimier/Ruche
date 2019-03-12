# Site web 

### Activation du module rewrite
Le site web de la ruche connectée utilise la réécriture d'url. Pour ce faire il est nécessaire d'activer le module **rewrite**.  

```bash
sudo a2enmod rewrite
```
Vous devez ensuite modifier le fichier de configuration d'apache:
éditer le fichier /etc/apache2/apache2.conf
```bash
sudo nano /etc/apache2/apache2.conf
```
Puis, recherchez toutes les lignes contenant:  **AllowOverride None** Et remplacez-les par **AllowOverride All**

Pour activer le moteur de réécriture, Ajouter à la fin du fichier apache2.conf les lignes suivantes:

```
<ifModule mod_rewrite.c>
RewriteEngine On
</ifModule>
```
Ensuite redémarrer le serveur apache2
```
systemctl restart apache2
```
Copier l'ensemble des pages du site web en exécutant les lignes suivantes.
```
mkdir /var/www/html/Ruche
cp -a /home/pi/Ruche/html/* /var/www/html/Ruche/
cp -a /home/pi/Ruche/html/.htaccess /var/www/html/Ruche/
```


# La page d'accueil

Le site web est accessible dans le répertoire Ruche à partir de la racine.

```
http://xxx.xxx.xxx.xxx/Ruche/
```
Remplacer  xxx.xxx.xxx.xxx par l'adresse IP de la raspberry.

### Changelog

 **12/03/2019 :** Ajout du README . 
 
 
> **Notes :**


> - Licence : **licence publique générale** ![enter image description here](https://img.shields.io/badge/licence-GPL-green.svg)
> - Auteur **Philippe SIMIER Lycée Touchard Le Mans**
>  ![enter image description here](https://img.shields.io/badge/built-passing-green.svg)
<!-- TOOLBOX 

Génération des badges : https://shields.io/
Génération de ce fichier : https://stackedit.io/editor#
https://docplayer.fr/15188945-Le-traitement-d-images-avec-opencv.html

