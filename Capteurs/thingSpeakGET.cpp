/*!
    @file     thingSpeakGET.cpp
    @author   Philippe SIMIER (Touchard Wahington le Mans)
    @license  BSD (see license.txt)
    @brief    Programme pour construire l'url (Update channel data with HTTP GET) API thingSpeak
    @date     15 Octobre 2018
    @version  v1.1 - First release
    @detail   Prérequis    : apt-get gammu gammu-smsd
              Compilation  : g++  thingSpeakGET.cpp SimpleIni.cpp i2c.cpp  bme280.cpp hx711.cpp bh1750.cpp spi.c -o thingSpeakGET
              Execution    : ./thingSpeakGET  write_api_key | envoyerURL
*/

#include <iostream>
#include <fstream>
#include <sstream>
#include <iomanip>
#include <ctime>

#include "hx711.h"
#include "bme280.h"
#include "bh1750.h"
#include "SimpleIni.h"

#define CONFIGURATION "/home/pi/Ruche/configuration.ini"

using namespace std;

int main(int argc, char *argv[])
{
    hx711 balance;
    bme280 capteur(0x77);
    bh1750 capteur2(0x23);
    SimpleIni ini;
    ostringstream trame;

    if (argc != 2){
        return 1;
    }

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
    balance.fixerSlope( ini.GetValue<float>("balance", "slope", 0.0 ));
    balance.fixerTempRef( ini.GetValue<float>("balance", "tempRef", 25.0 ));

    // Configuration du capteur de pression
    capteur.donnerAltitude( ini.GetValue<float>("ruche", "altitude", 0.0 ));

    // Configuration du capteur d'éclairement
    capteur2.configurer(BH1750_ONE_TIME_HIGH_RES_MODE_2);

    //string key = ini.GetValue<string>("thingSpeak", "key2", " ");
    string key(argv[1]);
    trame << "https://api.thingspeak.com/update?";
    trame << "api_key=" << key;
    trame << "&field1=" << fixed << setprecision (2) << balance.obtenirPoids();
    float temperature = capteur.obtenirTemperatureEnC();
    trame << "&field2=" << fixed << setprecision (2) << temperature;
    trame << "&field3=" << fixed << setprecision (2) << capteur.obtenirPression0();
    trame << "&field4=" << fixed << setprecision (2) << capteur.obtenirHumidite();
    trame << "&field5=" << fixed << setprecision (2) << capteur2.obtenirLuminosite_Lux();
    trame << "&field6=" << fixed << setprecision (2) << capteur.obtenirPointDeRosee();
    trame << "&field7=" << fixed << setprecision (2) << balance.obtenirPoidsCorrige(temperature);


    cout << trame.str() << endl;
    return 0;
}
