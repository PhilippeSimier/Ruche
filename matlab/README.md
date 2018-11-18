# Thing Speak - Matlab

## Présentation
ThingSpeak est à l’origine une **plate-forme IoT open source** dont l’objectif est de collecter, de stocker et de traiter des données générées par des objets connectés. En 2015, le projet a été repris par MathWorks. Depuis la plate forme a obtenue de nombreux services supplémentaires notamment une **intégration avec Matlab**. Elle permet aussi notamment de réagir lors de l’arrivée d’une donnée, ou encore de **programmer des actions automatiques**.

Les objets/capteurs communiquent leurs données à la plate-forme ThingSpeak au travers de requêtes HTTP. Un système de clés est présent pour assurer la sécurité des transmissions. Les données reçues sont  stockées dans une base de données relationnelle. L’insertion d’une donnée peut aussi être l’élément déclencheur d’une action comme par exemple l'exécution d’un script Matlab pour faire des opérations mathématiques ou envoyer une notification.



[Site web ThingSpeak](https://thingspeak.com)

## MATLAB Visualizations

Les tracés interactifs MATLAB® permettent de visualiser et d'explorer les données collectées dans un canal. Les diagrammes **nuage de points** permettent de mettre en évidence la corrélation entre les données. Les histogrammes permettent de représenter la **répartition** et la **dispersion** des données.


#### Exemple :
![dispersion température/poids ](/matlab/figure1.PNG)

[Script Matlab Nuage de points Température/Poids](/matlab/dispersion_poids_temperature.m)

![dispersion température/humidité ](/matlab/figure3.PNG)

[Script Matlab Nuage de points Température/Humidité](/matlab/dispersion_temperature_humidity.m)

![histogramme temps/poids ](/matlab/figure2.PNG)

[Script Matlab Histogramme Température](/matlab/histogramme_temperature.m)



## Changelog



## Changelog

 **31/10/2018 :** Ajout du README . 
 
 
> **Notes :**


> - Licence : **licence publique générale** ![enter image description here](https://img.shields.io/badge/licence-GPL-green.svg)
> - Auteur **Philippe SIMIER Lycée Touchard Le Mans**
>  ![enter image description here](https://img.shields.io/badge/built-passing-green.svg)
<!-- TOOLBOX 

Génération des badges : https://shields.io/
Génération de ce fichier : https://stackedit.io/editor#



