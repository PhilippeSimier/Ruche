% Create a scatter plot using the scatter function
readChannelID = 539387;
fieldTemperature = 2;
fieldHumidite = 4;
fieldPressure = 3;
nb = 15*48;
decalage = 0;
readAPIKey = 'BUIVFYM68IX7NKZF';
x = thingSpeakRead(readChannelID, 'Field', fieldTemperature, 'NumPoints', nb, 'ReadKey', readAPIKey); 
y = thingSpeakRead(readChannelID, 'Field', fieldHumidite, 'NumPoints', nb, 'ReadKey', readAPIKey); 
z = thingSpeakRead(readChannelID, 'Field', fieldPressure, 'NumPoints', nb, 'ReadKey', readAPIKey) 

figure
scatter(x, y, 10, z)

% Add title and axis labels
title('Humidity temperature')
xlabel('Temperature (°C)')
ylabel('Humidity (%)')

% Add a colorbar with tick labels
colorbar('Location', 'EastOutside', 'YTickLabel',...
    { '996 hPa' , '1000 hPa', '1006 hPa', '1012 hPa', '1018hPa', '1024 hPa', '1030 hPa', '1036 hPa'})


