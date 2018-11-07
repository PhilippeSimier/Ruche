readChannelID = 539387;
fieldTemperature = 2;
fieldPoids = 1;
nb = 7*48;

decalage = 0;
% Channel Read API Key 
readAPIKey = 'HSR8AJJ167TXXXK0';

%% Read Data %%

% Read first data variable
data1 = thingSpeakRead(readChannelID, 'Field', fieldTemperature, 'NumPoints', nb, 'ReadKey', readAPIKey);

dataTemp = data1(1:end-decalage);

% Read second data variable
dataPoids = thingSpeakRead(readChannelID, 'Field', fieldPoids, 'NumPoints', nb - decalage, 'ReadKey', readAPIKey);

% La fonction polyfit peut fournir un ajustement aux données linéaires
% lorsque le degré d’ajustement est défini sur une valeur de 1
fitData=polyfit(dataTemp,dataPoids,1);
display(fitData(1),'Slope kg/C ');
display(fitData(2),'Intercept b ');

y1 = polyval(fitData,dataTemp);

%% Visualize Data %%
s = 20;

figure
scatter(dataTemp, dataPoids, 10)
hold on
plot(dataTemp,y1)
hold off

Chaine = [' y = ', num2str(fitData(1)) , ' x + ' , num2str(fitData(2))];

title(Chaine);
legend('data','linear fit');
xlabel('temperature (°C)');
ylabel('Weight (g)');

% Concaténation horizontale des vecteurs data1 & data3 [data3,data2]
% Affichage de la matrice obtenue
display([dataTemp,dataPoids]);

