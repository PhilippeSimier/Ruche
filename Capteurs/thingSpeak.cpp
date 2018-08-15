/*!
    @file     thingSpeak.cpp
    @author   Philippe SIMIER (Touchard Wahington le Mans)
    @license  BSD (see license.txt)
    @brief    Programme pour logger le poids -> thingSpeak
    @date     Juin 2018
    @version  v1.0 - First release
    @detail   Prérequis    : apt-get update
                             apt-get install libcurl4-openssl-dev
              Compilation  : g++  thingSpeak.cpp HTTPDownloader.cpp SimpleIni.cpp i2c.cpp  bme280.cpp hx711.cpp bh1750.cpp spi.c  -lcurl -o thingSpeak
              Execution    : ./main
*/



#include <iostream>
#include <fstream>
#include <sstream>
#include <iomanip>

#include "hx711.h"
#include "bme280.h"
#include "bh1750.h"
#include "SimpleIni.h"
#include "HTTPDownloader.h"

#define CONFIGURATION "/home/pi/Ruche/configuration.ini"

using namespace std;

int main()
{
    hx711 balance;
    bme280 capteur(0x77);
    bh1750 capteur2(0x23);
    SimpleIni ini;
    HTTPDownloader downloader;
    ostringstream url;

    // Lecture du fichier de configuration
    if(!ini.Load(CONFIGURATION))
    {
        cout << "\"error\":\"Impossible d'ouvrir le fichier configuration.ini\"" << endl;
        return -1;
    }

    // Configuration de la balance
    balance.fixerEchelle( ini.GetValue<float>("balance", "scale", 1.0 ));
    balance.fixerOffset( ini.GetValue<int>("balance", "offset", 0));
    balance.configurerGain(  ini.GetValue<int>("balance", "gain", 128));

    // Configuration du capteur de pression
    capteur.donnerAltitude( ini.GetValue<float>("ruche", "altitude", 0.0 ));

    // Configuration du capteur d'éclairement
    capteur2.configurer(BH1750_ONE_TIME_HIGH_RES_MODE_2);

    string key = ini.GetValue<string>("thingSpeak", "key", " ");
    url << "https://api.thingspeak.com/update?api_key=" << key;
    url << "&field1=" << balance.obtenirPoids();
    url << "&field2=" << capteur.obtenirTemperatureEnC();
    url << "&field3=" << capteur.obtenirPression0();
    url << "&field4=" << capteur.obtenirHumidite();
    url << "&field5=" << capteur2.obtenirLuminosite_Lux();
   // cout << url.str() << endl;

    string contenu = downloader.obtenirUrl(url.str());
    cout << contenu << endl;

    return 0;
}
