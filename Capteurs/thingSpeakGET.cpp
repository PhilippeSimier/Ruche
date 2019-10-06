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
#include <math.h>       /* sqrt */

#include "hx711.h"
#include "bme280.h"
#include "bh1750.h"
#include "SimpleIni.h"

#define CONFIGURATION "/opt/Ruche/etc/configuration.ini"

using namespace std;

/**
 * @brief ObtenirDateHeure
 * @return std::string
 * @details retourne une chaine de caratères représentant la date courante
 *          au format Année-mois-jour heure:minute:seconde
 */

string ObtenirDateHeure()
{
    locale::global(locale("fr_FR.utf8"));
    time_t t = time(0);
    char Fchar[100];
    char Tchar[100];
    string dateHeure;
    if (strftime(Fchar, sizeof(Fchar), "%F", gmtime(&t))) {
        if (strftime(Tchar, sizeof(Tchar), "%T", gmtime(&t))) {
            string F(Fchar);
            string T(Tchar);
            dateHeure = F + "%20" + T;
        }
    }
    return dateHeure;
}




int main(int argc, char *argv[])
{
    hx711 balance;
    bme280 capteur(0x77);
    bh1750 capteur2(0x23);
    SimpleIni ini;
    ostringstream trame;
    float temperature = 20.0;
    bool presenceBME = !capteur.obtenirErreur();

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
    float scale =  ini.GetValue<float>("balance", "scale", 1.0 );
    balance.fixerEchelle( scale);
    balance.fixerOffset( ini.GetValue<int>("balance", "offset", 0));
    balance.configurerGain(  ini.GetValue<int>("balance", "gain", 128));
    balance.fixerSlope( ini.GetValue<float>("balance", "slope", 0.0 ));
    balance.fixerTempRef( ini.GetValue<float>("balance", "tempRef", 25.0 ));
    int precision = ini.GetValue<int>("balance", "precision", 2);

    // Configuration du capteur de pression
    if (presenceBME){
        capteur.donnerAltitude( ini.GetValue<float>("ruche", "altitude", 0.0 ));
        temperature = capteur.obtenirTemperatureEnC();
    }

    // Configuration du capteur d'éclairement
    capteur2.configurer(BH1750_ONE_TIME_HIGH_RES_MODE_2);
    if (capteur2.obtenirLuminosite_Lux() > 27000){
        capteur2.configurer(BH1750_ONE_TIME_HIGH_RES_MODE);
    }

    string key(argv[1]);
    trame << "https://api.thingspeak.com/update?";
    trame << "api_key=" << key;
    trame << "&field1=" << fixed << setprecision (precision) << balance.obtenirPoids();

    if (presenceBME){
        trame << "&field2=" << fixed << setprecision (2) << temperature;
        trame << "&field3=" << fixed << setprecision (2) << capteur.obtenirPression0();
        trame << "&field4=" << fixed << setprecision (2) << capteur.obtenirHumidite();
	trame << "&field6=" << fixed << setprecision (2) << capteur.obtenirPointDeRosee();
    }
    trame << "&field5=" << fixed << setprecision (2) << capteur2.obtenirLuminosite_Lux();
    trame << "&field7=" << fixed << setprecision (precision) << sqrt(balance.obtenirVariance())*1000/scale;
    trame << "&created_at=" << ObtenirDateHeure();

    cout << trame.str() << endl;
    return 0;
}
