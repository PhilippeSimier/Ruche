/*!
    @file     coulombCounter.cpp
    @author   Philippe SIMIER (Touchard Wahington le Mans)
    @license  BSD (see license.txt)
    @brief    Programme pour forger l'url des information batterie pour thingspeak
    @date     06 Avril 2019
    @version  v1.1 - First release
    @detail   Compilation  : g++  coulombCounter.cpp SimpleIni.cpp i2c.cpp  ina219.cpp -o coulombCounter
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

#define COULOMB "/opt/Ruche/etc/battery.ini"

int main(int argc, char *argv[])
{
    ina219 batterie;
    SimpleIni ini;
    float charge = 0.0;
    float i = 0.0;
    float u = 0.0;
    float capacite = 7.5;

    int t0,t1;
    int rendement;

    while(1){
        // Lecture du fichier de coulomb.ini
        if(!ini.Load(COULOMB)){
	    return -1;
        }
        // dernière capacité en Ah enregistrée
        charge = ini.GetValue<float>("battery", "charge", 0.0 );
        // Dernier timestamp enregistré
        t0 = ini.GetValue<int>("battery", "time", 0 );
        rendement = ini.GetValue<int>("battery", "rendement", 100 );

        if (!batterie.obtenirErreur()){

            i = batterie.obtenirCourantMoyen_A(100);
            t1 = time(0);
            if ((t1-t0) < 3600){  // deltaT maxi 1 heure utile après un long arrêt
                if ( i < 0)
                charge += i * (t1 - t0)/3600;
		else
                charge += i * (t1 - t0)/3600 * (rendement/100.0);
            }

            u = batterie.obtenirTension_V();
            if (u > 14.60 && charge > capacite)  // la charge est complète lorsque la tension est supérieur à 14.6
                charge = capacite;


            ini.SetValue<float>("battery", "charge", charge);
            ini.SetValue<int>("battery", "time", t1);

            if(!ini.Save())
                return -1;
        }
        sleep(10); // temporisation de 10 secondes
    }
    return 0;
}
