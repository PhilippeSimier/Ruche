/*!
    \file     balanceJson.cpp
    \author   Philippe SIMIER (Touchard Wahington le Mans)
    \license  BSD (see license.txt)
    \date   : 11 Juin 2018
    \brief   Programme pour l'envoi du poids au format JSON
    \details Renvoie la valeur mesurée au format JSON
    Compilation : g++ balanceJson.cpp hx711.cpp SimpleIni.cpp  spi.c -o balanceJson
    Installation: sudo chown root balanceJson
                  sudo chmod +s balanceJson
                  sudo cp balanceJson /usr/lib/cgi-bin/balanceJson

    \version	v1.0 - First release
*/

#include <iostream>
#include <fstream>
#include <iomanip>
#include <math.h>       /* sqrt */

#include "hx711.h"
#include "SimpleIni.h"

#define CONFIGURATION "/opt/Ruche/etc/configuration.ini"

using namespace std;

int main()
{

    hx711   balance;
    SimpleIni ini;

    string  unite;
    int     precision;

    cout << "Content-type: application/json" << endl << endl;
    cout << "{" << endl;

    // Lecture du fichier de configuration
    if(!ini.Load(CONFIGURATION))
    {
        cout << "\"success\": false, " << endl;
        cout << "\"error\":\"Impossible d'ouvrir le fichier configuration.ini\"" << endl;
	cout << "}" << endl;
        return -1;
    }

    precision = ini.GetValue<int>("balance", "precision", 1);

    // Configuration de la balance
    float scale =  ini.GetValue<float>("balance", "scale", 1.0 );
    balance.fixerEchelle( scale);
    balance.fixerOffset( ini.GetValue<int>("balance", "offset", 0));
    balance.configurerGain( ini.GetValue<int>("balance", "gain", 128));

    // Lecture du poids et de la variance
    float weight = balance.obtenirPoids();
    float variance = balance.obtenirVariance();


    // Envoi des données au format JSON
    cout << "\"success\": true ," << endl;
    cout << "\"Weight\": \"" << fixed << setprecision (precision) <<  weight << "\","<< endl;
    cout << "\"unite\": " << "\"" << ini.GetValue<string>("balance", "unite", "Kg") << "\"," << endl;
    cout << "\"dispersion\": \"" << fixed << setprecision (0) << sqrt(variance) * 1000 /scale << "\""<< endl;
    cout << "}" << endl;
}
