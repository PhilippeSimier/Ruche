% MATLAB code for visualizing correlated data using the
% THINGSPEAKSCATTER function.

readChannelID = 539387;

fieldID1 = 2;
fieldID2 = 4;
nb = 7 * 48;
s = 20;

readAPIKey = 'HSR8AJJ167TXXXK0';

% Read first data variable
data1 = thingSpeakRead(readChannelID, 'Field', fieldID1, 'NumPoints', nb, 'ReadKey', readAPIKey);

% Read second data variable
data2 = thingSpeakRead(readChannelID, 'Field', fieldID2, 'NumPoints', nb, 'ReadKey', readAPIKey);

%% Visualize Data %%

thingSpeakScatter(data1, data2, s,'xlabel','Temperature (°C)','ylabel','Humidité (%)');
