# panneaux solaires photovoltaïques

Le panneau solaire alimente la raspberry et charge la batterie de manière à ce qu'il ait assez d'énergie pour fonctionner pendant la période nocturne. Étant donné que la ruche connectée passe environ la moitié de son temps «dans le noir», elle doit s’appuyer sur l’énergie stockée dans la batterie embarquée pour fonctionner.

La capacité d'une batterie à stocker de l'énergie et à fournir cette énergie au fil du temps est mesurée en terme de capacité de stockage de la batterie.  Cette grandeur se mesure  en coulomb ou ampères-heures.  Le programme coulombCounter surveille en permanence la quantité de courant circulant dans la batterie. 

## Conversion de l’énergie solaire

La lumière est composée de photons, porteurs d’énergie, pouvant extraire des charges électriques des matériaux semi-conducteurs tels que le silicium. Ainsi les panneaux solaires  produisent du courant électrique quand ils sont exposés à la lumière, par cette conversion photovoltaïque.

## Les différentes technologies   
 
### Panneaux solaires au silicium cristallin 
Le matériau photovoltaïque le plus couramment utilisé aujourd’hui est le **silicium cristallin, mono ou polycristallin**, à cause de sa grande disponibilité sur terre (dans le sable), sa bonne qualité électronique et donc son bon rendement de conversion au soleil. Le rendement énergétique des panneaux solaires à base polycristalline est généralement de 13 à 16%.

### Panneaux solaires au silicium amorphe

Le silicium amorphe quant à lui, présente des avantages spécifiques :

 - Réponse à **faible éclairement et sous ensoleillement diffus** ( par temps couvert de 20 à 3 000 lux)
 - Facilité de mise en oeuvre sur de petits formats, à toutes les tensions
 - Quasi insensibilité à la hausse de température au soleil

### Caractérisques

Le Watt crête (Wc) est la puissance nominale que délivre un panneau photovoltaïque dans les conditions optimales c'est à dire : une puissance d’ensoleillement de 1 000 W/m2, les rayons perpendiculaires au capteur, la température des cellules à 25° C.

## Choix
On suppose que la puissance d’un panneau solaire est proportionnelle à l’éclairement, même lorsqu’il est faible. Ce qui est loin d’être le cas pour toutes les technologies ! Le silicium cristallin voit sa tension en particulier baisser fortement quand l’éclairement baisse et il ne peut guère produire en dessous de 100 W/m² (10 000 lux). 

Le silicium amorphe, quant à lui, possède un moindre rendement au soleil, mais il est adapté à tous les éclairements. Or dans le cas d'un ciel nuageux, l’éclairement ne dépasse pas les 1000-3000 lux. Le **silicium amorphe** est donc bien souvent le meilleur choix pour produire tout au long de l’année, par tous les temps. 

## Composition

Le système photovoltaïque autonome comprend :

 - un (ou plusieurs) panneaux solaire(s) photovoltaïque(s) au silicium
 - un régulateur de charge 
 - une batterie  LiFePO4 selon la capacité requise et la durée de vie
 - des composants de conversion DC/DC  (12V/5V)

Le but du régulateur est avant tout de protéger la batterie contre les effets de surcharge et de décharge profonde.


## Changelog

 
 **08/05/2019 :** Ajout choix du panneau solaire photovoltaïque
 
> **Notes :**


> - Licence : **licence publique générale** ![enter image description here](https://img.shields.io/badge/licence-GPL-green.svg)
> - Auteur **Philippe SIMIER Lycée Touchard Le Mans**
>  ![enter image description here](https://img.shields.io/badge/built-passing-green.svg)
<!-- TOOLBOX 

Génération des badges : https://shields.io/
Génération de ce fichier : https://stackedit.io/editor#



