/*!
    @file     mesuresSigfox.cpp
    @author   Philippe SIMIER (Touchard Wahington le Mans)
    @license  BSD (see license.txt)
    @brief    Programme pour envoyer les mesures via Sigfox
    @date     25 Juillet 2020
    @version  v1.0 - First release
    @detail   Compilation  :
      g++  mesuresSigfox.cpp SimpleIni.cpp i2c.cpp  bme280.cpp hx711.cpp bh1750.cpp spi.c serie.c sigfox.cpp -o mesuresSigfox
              Execution    : ./mesuresSigfox
	      Installation : cp mesuresSigfox /opt/Ruche/bin/mesuresSigfox
*/

#include <iostream>
#include <iomanip>

//#pragma pack(1)

#include "sigfox.h"
#include "hx711.h"
#include "bme280.h"
#include "bh1750.h"
#include "SimpleIni.h"


#define CONFIGURATION "/opt/Ruche/etc/configuration.ini"

typedef struct {
    short field1;
    short field2;
    short field3;
    unsigned short field5;
    short field6;
    unsigned char  field4;
    unsigned char  type;
} trame;

using namespace std;


int main(int argc, char *argv[])
{
    trame t;
    Sigfox device("/dev/ttyS0", true);

    hx711 balance;
    bme280 capteur(0x77);
    bh1750 capteur2(0x23);
    SimpleIni confIni;


    bool presenceBME = !capteur.obtenirErreur();


    // Lecture du fichier de configuration
    if(!confIni.Load(CONFIGURATION))
    {
        cout << "\"error\":\"Impossible d'ouvrir le fichier configuration.ini\"" << endl;
        return -1;
    }

    // Configuration de la balance
    float scale =  confIni.GetValue<float>("balance", "scale", 1.0 );
    balance.fixerEchelle( scale);
    balance.fixerOffset( confIni.GetValue<int>("balance", "offset", 0));
    balance.configurerGain( confIni.GetValue<int>("balance", "gain", 128));
    balance.fixerSlope( confIni.GetValue<float>("balance", "slope", 0.0 ));
    balance.fixerTempRef( confIni.GetValue<float>("balance", "tempRef", 25.0 ));
    int precision = confIni.GetValue<int>("balance", "precision", 2);

    // Configuration du capteur de pression
    if (presenceBME){
        capteur.donnerAltitude( confIni.GetValue<float>("ruche", "altitude", 0.0 ));
    }

    // Configuration du capteur d'éclairement
    capteur2.configurer(BH1750_ONE_TIME_HIGH_RES_MODE_2);
    if (capteur2.obtenirLuminosite_Lux() > 27000){
        capteur2.configurer(BH1750_ONE_TIME_HIGH_RES_MODE);
    }

    t.type = 1;
    t.field1 = (short)(balance.obtenirPoids() * 100);

    if (presenceBME){
        t.field2 = (short)(capteur.obtenirTemperatureEnC() * 100);
        t.field3 = (short)(capteur.obtenirPression0() * 10);
        t.field4 = (char) capteur.obtenirHumidite();
        t.field6 = (short)(capteur.obtenirPointDeRosee() * 100);
    }else{
        t.field2 = 0;
        t.field3 = 0;
        t.field4 = 0;
        t.field6 = 0;
    }
    t.field5 = (short)capteur2.obtenirLuminosite_Lux();

    cout << device.envoyer((void*)&t,12) << endl;
    return 0;
}
