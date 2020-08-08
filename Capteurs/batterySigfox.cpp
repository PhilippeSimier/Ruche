/*!
    @file     batterySigfox.cpp
    @author   Philippe SIMIER (Touchard Wahington le Mans)
    @license  BSD (see license.txt)
    @brief    Programme pour envoyer les mesures via Sigfox
    @date     26 Juillet 2020
    @version  v1.0 - First release
    @detail   Compilation  :
      g++  batterySigfox.cpp SimpleIni.cpp i2c.cpp  ina219.cpp serie.c sigfox.cpp -o batterySigfox
              Execution    : ./batterySigfox
	      Installation : cp batterySigfox /opt/Ruche/bin/batterySigfox
*/

#include <iostream>
#include <iomanip>


#include "sigfox.h"
#include "ina219.h"
#include "SimpleIni.h"


#define CONFIGURATION "/opt/Ruche/etc/configuration.ini"
#define BATTERY "/opt/Ruche/etc/battery.ini"

typedef struct {
    short field1;
    short field2;
    short field3;
    unsigned short field5;
    short field6;
    unsigned char  field4;
    unsigned char  type;
} trame;

/* field1::int:16:little-endian
   field2::int:16:little-endian
   field3::int:16:little-endian
   field5::uint:16:little-endian
   field6::int:16:little-endian
   field4::uint:8
   type::uint:8
*/

using namespace std;


int main(int argc, char *argv[])
{
    trame t;
    Sigfox device("/dev/ttyS0", true);

    ina219 batterie;
    SimpleIni batIni;
    float charge = 0.0;
    float capacite;
    float i0 = 0.0;
    int t0,t1;


    // Lecture du fichier de configuration
    if(!batIni.Load(BATTERY))
    {
        cout << "\"error\":\"Impossible d'ouvrir le fichier battery.ini\"" << endl;
        return -1;
    }

    // dernière capacité en Ah enregistrée
    charge = batIni.GetValue<float>("battery", "charge", 0.0 );
    t0 = batIni.GetValue<int>("battery", "time", 0 );
    i0 = batIni.GetValue<float>("battery", "current", 0.0 );
    capacite = batIni.GetValue<float>("battery", "capacite", 7.0 );

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

        t.field1 = (short)(u * 100);
        t.field2 = (short)(i1 * 100);
        t.field3 = (short)(p * 100);
        t.field4 = (unsigned char)(soc * 2);
        t.field5 = (unsigned short)(charge * 1000);
        t.field6 = 0;
    }else{
        t.field1 = 0;
        t.field2 = 0;
        t.field3 = 0;
        t.field4 = 0;
        t.field5 = 0;
        t.field6 = 0;
    }
    t.type = 2;
    cout << device.envoyer((void*)&t,12) << endl;

    if(!batIni.SaveAs(BATTERY)){
        return -1;
    }

    return 0;
}
