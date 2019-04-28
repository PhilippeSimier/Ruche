# Batterie

## Choix
  
  Le tableau ci-dessous vous donne un élément de comparaison entre une batterie: **Plomb**, **Lithium NMC** (Lithium Nickel Manganèse Cobalt) et **Lithium LFP** (Lithium Fer Phosphate). 
  
  | type                    |  Plomb   |     LIFEPO4 |     NMC    |
  |-------------------------|----------|-------------|------------|
  | tension   V             |   12     |     12.8    |  14.4      |
  | Energie Massique        | 40 Wh/kg | 120 Wh/kg   |  200 Wh/Kg | 
  | Durée de vie à 100% DOD |   300    |     500     |  2000      |
  | Durée de vie à 80% DOD  |   600    |     3000    |   800      | 
  | Profondeur décharge     |   50%    |     90%     |  90%       |
  | Rendement à C           |	60%    |     95%     |  95%       |
  |	Indice de prix          |   100    |    400      |  320       |
  | Temps de charge         |   8h     |      1h     |   2h       |


 
Les principaux avantages des batteries LIFEPO4 sont : un gain de poids, une durée de vie augmentée sans entretien, des cycles de recharge et de décharge rapide avec un excellent rendement énergétique.

##2 Unité de charge

le coulomb  est défini comme un ampère pendant une seconde :

    1A x 1s = 1C

Puisqu'il y a 3600 secondes dans une heure, un ampère-heure équivaut à 3600 coulombs:

    1Ah = 3600C

 
##2 Détermination du SOC

Il existe plusieurs manières pour mesurer l’état de charge (SoC) ou la profondeur de décharge (DoD) d’une batterie. 

####2-1 Mesure d’état de charge (SoC) par méthode OCV (Open Circuit Voltage)
Tous les types de batteries ont un point commun : la tension à leurs bornes diminue ou augmente en fonction de leur niveau de charge. La tension sera maximale lorsque la batterie est totalement chargée et minimale lorsqu’elle est vide. 
Cette relation entre tension et SOC dépend directement de la technologie de batterie utilisée.
le schéma ci dessous montre la courbe de décharge pour une batterie au plomb de 7Ah 12V
![courbe batterie lead](/Batterie/batterie_lead.png)
On peut constater que la batterie au plomb a une courbe relativement linéaire, ce qui permet une bonne estimation de l’état de charge connaissant la tension en circuit ouvert.
C'est le moyen utilisé par la méthode **obtenirSOC** de la classe **ina219**.
```cpp
 float ina219::obtenirSOC()
```
 
####2-2 2 Mesure d’état de charge (SoC) par compteur de Coulomb
Pour suivre l’état de charge lors de l’utilisation de la batterie, la méthode la plus intuitive consiste à suivre le courant en l’intégrant durant l’utilisation. Cette intégration donne de manière directe la quantité de charges électriques injectées ou soutirées à la batterie permettant ainsi de quantifier précisément le SoC de la batterie.
le SOC est le rapport entre la charge et la capacité nominale exprimé en %.
Contrairement à la méthode OCV, cette méthode est en mesure de déterminer l’évolution de l’état de charge pendant l’utilisation de la batterie. Elle ne nécessite pas que la batterie soit au repos pour effectuer une mesure précise.

C'est la méthode utilisée par le programme **/Capteurs/battery.cpp**
Pour garder une trace de la charge, le dernier état de charge calculé  est enregistré dans le fichier **battery.ini**

Bien que la mesure du courant soit effectuée par une résistance de précision 0.1 Ohm, de faibles erreurs de mesures interviennent, liées à la fréquence échantillonnage de la mesure. Pour corriger ces erreurs marginales, le compteur de Coulomb est repositionné automatiquement à chaque cycle de charge.

## Changelog

 
 **28/04/2019 :** Ajout choix de la batterie
 
> **Notes :**


> - Licence : **licence publique générale** ![enter image description here](https://img.shields.io/badge/licence-GPL-green.svg)
> - Auteur **Philippe SIMIER Lycée Touchard Le Mans**
>  ![enter image description here](https://img.shields.io/badge/built-passing-green.svg)
<!-- TOOLBOX 

Génération des badges : https://shields.io/
Génération de ce fichier : https://stackedit.io/editor#



