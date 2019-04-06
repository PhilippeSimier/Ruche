/**
 *  @file     testBalance.cpp
 *  @author   Philippe SIMIER (Touchard Wahington le Mans)
 *  @license  BSD (see license.txt)
 *  @date     15 avril 2018
 *  @brief    programme pour tester le fct de la balance
 *            compilation: g++ testBalance.cpp hx711.cpp SimpleIni.cpp spi.c -o testBalance
*/

#include <iostream>
#include <fstream>
#include <iomanip>

#include "hx711.h"
#include "SimpleIni.h"

#define CONFIGURATION "/opt/Ruche/etc/configuration.ini"

using namespace std;

int main()
{

    hx711 balance;
    SimpleIni ini;
    float xn;
    float xn_1 = 0.0;
    char  stable;
    float scale;
    int   offset;
    int   gain;
    string unite;
    int   precision = 1;
    float slope;
    float tempRef;

    // Lecture du fichier de configuration
    ini.Load(CONFIGURATION);
    scale  = ini.GetValue<float>("balance", "scale", 1.0 );
    offset = ini.GetValue<int>("balance", "offset", 0);
    gain   = ini.GetValue<int>("balance", "gain", 128);
    unite  = ini.GetValue<string>("balance", "unite", "Kg");
    precision = ini.GetValue<int>("balance", "precision", 1);
    slope = ini.GetValue<float>("balance", "slope", 0.0 );
    tempRef = ini.GetValue<float>("balance", "tempRef", 20.0 );

    // Configuration de la balance
    balance.fixerEchelle(scale);
    balance.fixerOffset(offset);
    balance.configurerGain(gain);
    balance.fixerSlope(slope);
    balance.fixerTempRef(tempRef);
    while(1)
    {
	xn = balance.obtenirPoidsCorrige(25.0);
        system("clear");

	// calcul de la dérivée
	if ((xn_1 - xn) < 0.1 && (xn_1 - xn) > - 0.1)
            stable = '*';
        else stable = ' ';
        xn_1 = xn;

        cout << stable << " " << xn << fixed << setprecision (precision) << " " << unite << endl;
    }
}
