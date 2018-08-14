% Calcul de la dérivée du poids 
% La dérivée du poids est nécessaire pour envoyer des alertes en cas de 
% variations brutales


% Channel ID to read data from 
readChannelID = 539387; 
writeChannelID = 558210; 

% Poids Field ID 
PoidsFieldID = 1; 

% Channel Read API Key 
readAPIKey = 'HSR8AJJ167TXXXK0'; 
writeAPIKey = '3RPCCIIT1JJHM25A'; 

% il suffit d'avoir deux valeurs pour calculer la dérivée 
nb = 2; 

[poids,time] = thingSpeakRead(readChannelID,'Fields',1,'NumPoints',nb,'ReadKey',readAPIKey); 

dt = seconds(diff(time))/3600; 
dx = diff(poids); 

% Calcul de la dérivée numérique en g/h 
df = round(diff(poids)./dt,2); 
display(df,'diff(poids)');

response = thingSpeakWrite(writeChannelID,df,'writekey',writeAPIKey);
