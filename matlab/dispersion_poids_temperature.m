% Template MATLAB code for visualizing correlated data using the 
% THINGSPEAKSCATTER function. 
% Prior to running this MATLAB code template, assign the channel ID to read 
% data from to the 'readChannelID' variable. Also, assign the field IDs 
% within the channel that you want to read data from to 'fieldID1', and 
%'fieldID2'. 


readChannelID = 539387; 
fieldTemperature = 2; 
fieldPoids = 1; 
nb = 5*48; 
decalage = 10; 

% Channel Read API Key readAPIKey = 'HSR8AJJ167TXXXK0'; 

%% Read Data %% 

% Read first data variable 
data1 = thingSpeakRead(readChannelID, 'Field', fieldTemperature, 'NumPoints', nb, 'ReadKey', readAPIKey); 
data3 = data1(1:end-decalage); 

% Read second data variable 
data2 = thingSpeakRead(readChannelID, 'Field', fieldPoids, 'NumPoints', nb - decalage, 'ReadKey', readAPIKey); 

%% Visualize Data %% 
s = 20; 
thingSpeakScatter(data3, data2,s,'xlabel','Température (°C)','ylabel','Poids (g)'); 

% Concaténation horizontale des vecteurs data1 & data3 
x = [data3,data2]; 

% Affichage de la matrice obtenue 
display(x);
