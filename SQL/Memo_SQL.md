# Mémo SQL

## Connexion au serveur

La ligne de commande suivante permet de se connecter au serveur mysql en tant qu’utilisateur ruche (attention pas d'espace entre -p et le mot de passe).
```bash
mysql -u ruche -pxxxxxxxx72
Welcome to the MariaDB monitor.  Commands end with ; or \g.
Your MariaDB connection id is 98894
Server version: 10.1.26-MariaDB-0+deb9u1 Debian 9.1

Copyright (c) 2000, 2017, Oracle, MariaDB Corporation Ab and others.

Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.

MariaDB [(none)]> show databases;
+--------------------+
| Database           |
+--------------------+
| data               |
| information_schema |
+--------------------+
2 rows in set (0.00 sec)

MariaDB [(none)]> use data;

```

## Ajouter une colonne 

Pour modifier la structure d'une table:  **ALTER**
La requète suivante ajoute une colonne status  **ADD `status`** de type enum à la table **things** après la colonne **name**.
```sql
 ALTER TABLE `things` ADD `status` ENUM('public','private') NULL DEFAULT NULL AFTER `name`;
```
## Mettre à jours la valeur d'un champ
Pour mettre à jour la valeur d'un champ : **UPDATE**
La requête suivante met à jours le champ **status** dans la table **things** pour la ligne dont l'**id** est égal à 1
```sql
UPDATE `data`.`things` SET `status` = 'public' WHERE `things`.`id` = 1;
```
## Créer une vue
Une vue est considérée comme une table virtuelle car elle n'a pas d’existence propre.
Une vue est créée à partir d'une requête de définition. 
```sql
CREATE
 ALGORITHM = UNDEFINED
 VIEW `users_things`
 AS SELECT `name`, `USER_API_Key`,`tag` FROM `things`,`users` where `user_id`=`users`.id
```
Interroger la vue `users_things`

Une fois créée une vue s’interroge comme une table. 
```sql
MariaDB [data]> SELECT * FROM `users_things`;
+----------------+------------------+----------+
| name           | USER_API_Key     | tag      |
+----------------+------------------+----------+
| Ruche France   | 9L0V9YXONAUJ0QRH | beehive  |
| Ruche Danemark | 9L0V9YXONAUJ0QRH | danemark |
| Ruche Philippe | RC8IK9LVVYEYZNSM | beehive  |
+----------------+------------------+----------+
3 rows in set (0.01 sec)

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

