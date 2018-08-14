% Enter your MATLAB Code below 
readChId = 539387; % Beehive 
writeChId = 556419; % Point de rosée 

writeKey = '7VX28B24FEE50ZTO'; 

% lecture des nb dernières valeurs 
nb = 1; 

[temp,time] = thingSpeakRead(readChId,'Fields',2,'NumPoints',nb); 
humidity = thingSpeakRead(readChId,'Fields',4,'NumPoints',nb); 

display(time, 'time'); 

b = 17.62; % constant for water 
vapor c = 243.5; % constant for barometric pressure 

% Calcul du point de rosée arrondi à deux chiffres derrières la virgule 
gamma = log(humidity/100) + b*temp./(c+temp); 
dewPoint = round(c*gamma./(b-gamma),2);
 
thingSpeakWrite(writeChId,[temp,humidity,dewPoint],'Fields',[1,2,3],...
'TimeStamps',time,'Writekey',writeKey);
