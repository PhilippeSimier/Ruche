/*!
    @file     battery.cpp
    @author   Philippe SIMIER (Touchard Wahington le Mans)
    @license  BSD (see license.txt)
    @brief    Programme pour forger l'url des information batterie pour thingspeak
    @date     11 Juillet 2020
    @version  v2.1 - second release Méthode Trapèze
    @detail   Compilation  : g++  battery.cpp SimpleIni.cpp i2c.cpp  ina219.cpp -o battery
              Execution    : ./battery server1 | envoyerURL
	          ou           : ./battery server2 | envoyerURL
			  installation : cp battery /opt/Ruche/bin/battery
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
#define CONFIGURATION "/opt/Ruche/etc/configuration.ini"


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
    string retour;
    if (strftime(Fchar, sizeof(Fchar), "%F", gmtime(&t))) {
        if (strftime(Tchar, sizeof(Tchar), "%T", gmtime(&t))) {
            string F(Fchar);
            string T(Tchar);
            retour = F + "+" + T;
        }
    }
    return retour;
}

int main(int argc, char *argv[])
{
    ina219 batterie;
    ostringstream trame;
    SimpleIni batIni;
    SimpleIni confIni;
    float charge = 0.0;
    float capacite;
    float i0 = 0.0;
    int t0,t1;

    // Lecture du fichier de battery.ini
    if(!batIni.Load(BATTERY)){
	return 2;
    }
    // dernière capacité en Ah enregistrée
    charge = batIni.GetValue<float>("battery", "charge", 0.0 );
    // Dernier timestamp enregistré
    t0 = batIni.GetValue<int>("battery", "time", 0 );
    // Dernière valeur du courant enregistré
    i0 = batIni.GetValue<float>("battery", "current", 0.0 );
    // Lecture de la capacité nominale
    capacite = batIni.GetValue<float>("battery", "capacite", 7.0 );

    // Lecture du fichier de configuration.ini
    if(!confIni.Load(CONFIGURATION)){
	return 3;
    }

    if (argc != 2){
        return 1;
    }
    // Lecture de la clé API canal Battery
    string key = confIni.GetValue<string>("Aggregator","batteryKey","ABC");
    // Lecture URL serveur aggregator
    // le premier argument contient la clé de l'URL (server1 ou server2)
    string keyUrl(argv[1]);

    if(keyUrl == "server1"){
	sleep(1);
    }else{
        sleep(2);
    }

    string server = confIni.GetValue<string>("Aggregator", keyUrl, "https://api/thingspeak.com");

    if (!batterie.obtenirErreur()){

	    float u = batterie.obtenirTension_V();
    	float i1 = batterie.obtenirCourantMoyen_A(100);
    	float p = u*i1;
    	float soc;

        t1 = time(0);
        if ((t1-t0) < 3600)  // deltaT maxi 1 heure utile après un long arrêt
            charge += (i1 + i0) * (t1 - t0) / 7200;
        if (charge < 0) {
	    charge = 0;  // La charge ne peut pas être négative
        }

        soc = (charge / capacite) * 100;
        if (soc > 100){
	        soc = 100;       // Le SOC maxi est limité à 100%
			charge = capacite; // La charge ne peut pas dépasser la capacité
	    }


        batIni.SetValue<float>("battery", "charge", charge);
        batIni.SetValue<int>("battery", "time", t1);
        batIni.SetValue<float>("battery", "current", i1);
        trame << server;
        trame << "/update?";
        trame << "api_key=" << key;
        trame << "&field1=" << fixed << setprecision (2) << u;
        trame << "&field2=" << fixed << setprecision (2) << i1;
        trame << "&field3=" << fixed << setprecision (2) << p;
        trame << "&field4=" << fixed << setprecision (2) << soc;
        trame << "&field5=" << fixed << setprecision (2) << charge;

        trame << "&created_at=" << ObtenirDateHeure();

        cout << trame.str() << endl;
    }

    if(!batIni.SaveAs(BATTERY))
    {
        return -1;
    }
    return 0;
}
