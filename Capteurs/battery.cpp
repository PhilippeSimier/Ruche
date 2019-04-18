/*!
    @file     battery.cpp
    @author   Philippe SIMIER (Touchard Wahington le Mans)
    @license  BSD (see license.txt)
    @brief    Programme pour forger l'url des information batterie pour thingspeak
    @date     06 Avril 2019
    @version  v1.1 - First release
    @detail   Compilation  : g++  battery.cpp SimpleIni.cpp i2c.cpp  ina219.cpp -o battery
              Execution    : ./battery your_write_api_key | envoyerURL
*/

#include <iostream>
#include <fstream>
#include <sstream>
#include <iomanip>
#include <ctime>
#include <string>

#include "ina219.h"
using namespace std;
#include "SimpleIni.h"

#define BATTERY "/opt/Ruche/etc/battery.ini"



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
    if (strftime(Fchar, sizeof(Fchar), "%F", gmtime(&t))) {
        if (strftime(Tchar, sizeof(Tchar), "%T", gmtime(&t))) {
            string F(Fchar);
            string T(Tchar);
            return F + "%20" + T;
        }
    }
}

int main(int argc, char *argv[])
{
    ina219 batterie;
    ostringstream trame;
    SimpleIni ini;
    float capacite = 0.0;
    int t0,t1;

    // Lecture du fichier de battery.ini
    if(!ini.Load(BATTERY)){
	return 2;
    }
    // dernière capacité en Ah enregistrée
    capacite = ini.GetValue<float>("battery", "capacite", 0.0 );
    // Dernier timestamp enregistré
    t0 = ini.GetValue<int>("battery", "time", 0 );

    if (argc != 2){
        return 1;
    }
    if (!batterie.obtenirErreur()){

	float u = batterie.obtenirTension_V();
    	float i = batterie.obtenirCourantMoyen_A(100);
    	float p = u*i;
    	float soc = batterie.obtenirSOC();

        t1 = time(0);
        if ((t1-t0) < 3600)  // deltaT maxi 1 heure utile après un long arrêt
        	capacite += i * (t1 - t0)/3600;
        if (capacite < 0) {
	    capacite = 0;  // La capacité ne peut pas être négative
        }

        ini.SetValue<float>("battery", "capacite", capacite);
        ini.SetValue<int>("battery", "time", t1);


        // le premier argument contient la clé de l'api
        string key(argv[1]);
        trame << "https://api.thingspeak.com/update?";
        trame << "api_key=" << key;
        trame << "&field1=" << fixed << setprecision (2) << u;
        trame << "&field2=" << fixed << setprecision (3) << i;
        trame << "&field3=" << fixed << setprecision (2) << p;
        trame << "&field4=" << fixed << setprecision (2) << soc;
        trame << "&field5=" << fixed << setprecision (5) << capacite;

        trame << "&created_at=" << ObtenirDateHeure();

        cout << trame.str() << endl;
    }

    if(!ini.SaveAs(BATTERY))
    {
        return -1;
    }
    return 0;
}
