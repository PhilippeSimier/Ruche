% Read temperature for the last week from a ThingSpeak channel and 
% visualize temperature variations using the MATLAB HISTOGRAM function. 
   
% Channel 539387 contains data from the Connected beehive Station, located 
% in Le Mans, France. The data is collected once every half an hour. Field 
% 2 contains temperature data. 
% Channel ID to read data from 
readChannelID = 539387; 
   
% Temperature Field ID 
TemperatureFieldID = 2; 
   
% Channel Read API Key   
readAPIKey = 'HSR8AJJ167TXXXK0'; 

% Get temperature data from field 4 for the last 10 hours = 10 x 60 
% minutes. Learn more about the THINGSPEAKREAD function by going to 
% the Documentation tab on the right side pane of this page. 
   
tempC = thingSpeakRead(readChannelID,'Fields',TemperatureFieldID,...
'NumDays',7, 'ReadKey',readAPIKey); 

dewpoint = thingSpeakRead(readChannelID,'Fields',6,...
'NumDays',7, 'ReadKey',readAPIKey); 
   
h1 = histogram(tempC);
hold on
histogram(dewpoint,h1.BinEdges);
hold off

% Add a legend
legend('temperature', 'dew point')
xlabel('Temperature (C)'); 
ylabel('Number of Measurements\newline for Each Temperature'); 
title('Histogram of Temperature Variation');