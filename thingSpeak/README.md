# API ThingSpeak

## Lecture des datas enregistrées dans un channel
Les noms des champs  associés à un channel peuvent être obtenues en interrogeant l'api  thingspeak avec la requête suivante.   Pour obtenir uniquement les informations sur le channel et les noms des champs associés, fixer le paramètre **results** à 0 (nombre de datas renvoyées = 0).
 
```html
https://api.thingspeak.com/channels/539387/feed.json?results=0
```
La réponse obtenue est un objet au format JSON:
```javascript
{"channel":{
	"id":539387,
	"name":"Mesures",
	"description":"mesures intérieures ...",
	"latitude":"47.92647",
	"longitude":"0.159561",
	"field1":"Weight (g)",
	"field2":"Temperature (°C)",
	"field3":"Pressure (hPa)",
	"field4":"Humidity (%)",
	"field5":"Illuminance (Lux)",
	"field6":"dew point (°C)",
	"field7":"Corrected Weight",
	"created_at":"2018-07-14T15:28:23Z",
	"updated_at":"2018-10-29T10:59:43Z",
	"elevation":"60.2",
	"last_entry_id":9635
	},
"feeds":[]
}
```
 



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



