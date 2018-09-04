readChannelID = 566173;
fieldTemperature = 2;
fieldPoids = 1;
nb = 24;
decalage = 0;
readAPIKey = 'BUIVFYM68IX7NKZF';

%% Read Data %%

% Read first data variable
data1 = thingSpeakRead(readChannelID, 'Field', fieldTemperature, 'NumPoints', nb, 'ReadKey', readAPIKey); 
dataTemp = data1(1:end-decalage);

% Read second data variable
dataPoids = thingSpeakRead(readChannelID, 'Field', fieldPoids, 'NumPoints', nb - decalage, 'ReadKey', readAPIKey); 

%% Visualize Data %%
s = 20;

thingSpeakScatter(dataTemp, dataPoids,s,'xlabel','Température (°C)','ylabel','Poids (kg)'); 

% La fonction polyfit peut fournir un ajustement aux données linéaires
% lorsque le degré d’ajustement est défini sur une valeur de 1.
fitData=polyfit(dataTemp,dataPoids,1);
display(fitData(1),'Slope kg/C ');
display(fitData(2),'Intercept b ');

% Concaténation horizontale des vecteurs data1 & data3
x = [dataTemp,dataPoids];

% Affichage de la matrice obtenue
% display(x);
