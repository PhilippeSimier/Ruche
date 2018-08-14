% Programme MATLAB Analysis  pour calculer
% la valeur moyenne journalière des fields 1,2,3 et 4 du channel 539387

% Channel ID to read data from 
readChannelID = 539387; 
% Humidity Field 
ID PoidsFieldID = 1; 

% Channel Read API Key 
% If your channel is private, then enter the read API Key between the '' below: 
readAPIKey = 'XXXXXXXXXXXXXXK0'; 
nb = 48; 

poids = thingSpeakRead(readChannelID,'Fields',1,'NumPoints',nb,'ReadKey',readAPIKey); 
temperature = thingSpeakRead(readChannelID,'Fields',2,'NumPoints',nb,'ReadKey',readAPIKey); 
pression = thingSpeakRead(readChannelID,'Fields',3,'NumPoints',nb,'ReadKey',readAPIKey); 
humidite = thingSpeakRead(readChannelID,'Fields',4,'NumPoints',nb,'ReadKey',readAPIKey);
 
% Calculate the average en omettant les valeurs NaN 
avgPoids = mean(poids,'omitnan'); 
display(avgPoids,'Poids moyen');
 
,avgTemp = mean(temperature,'omitnan'); 
display(avgTemp, 'Temp moyen');
 
avgPression = mean(pression,'omitnan'); 
display(avgPression, 'Pression moyenne'); 

avgHumidite = mean(humidite,'omitnan');
display(avgHumidite, 'Humidite moyenne');

% Replace the [] with channel ID to write data to: 
writeChannelID = 552430; 
% Enter the Write API Key between the '' below: 
writeAPIKey = 'XXXXXXXXXXXXXXXX'; 

% Learn more about the THINGSPEAKWRITE function by going to the Documentation tab on 
% the right side pane of this page. 

response = thingSpeakWrite(writeChannelID,{avgPoids,avgTemp,avgPression,avgHumidite},'writekey',writeAPIKey);
display(response, 'reponse');
