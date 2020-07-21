/*!
    @file     sigfox.cpp
    @author   Philippe SIMIER (Touchard Wahington le Mans)
    @license  BSD (see license.txt)
    @brief    Programme pour envoyer les data sur le middlewar Sigfox
    @date     18 Juillet 2020
    @version  v1.0 - first release
    @detail   Compilation  : g++  sigfox.cpp serie.c SimpleIni.cpp i2c.cpp  bme280.cpp hx711.cpp bh1750.cpp spi.c -o sigfox
              Execution    : ./sigfox
	     Installation  : cp sigfox /opt/Ruche/bin/sigfox
*/

#include <iostream>
#include <iomanip>
#include <sstream>
#include "serie.h"

using namespace std;

int main(int argc, char *argv[])
{

    int fdSerie;
    char message[100];
    char device[]="/dev/ttyS0";
    ostringstream trame;
    short type = 1;

    float poids = 39.67;
    short field1 = (short)(poids * 10);

    float temperature = 50.12;
    short field2 = (short)(temperature * 10);

    float pression = 1024.8;
    short field3 = (short)(pression * 10);

    float humidite = 65.2;
    short  field4 = (short)humidite;

    float eclairement = 48214.3;
    short field5 = (short)eclairement;

    float dewPoint = 20.3;
    short field6 = (short)(dewPoint * 10);

    fdSerie = ouvrirPort(device);
    configurerSerie(fdSerie, 9600, NOECHO);

    trame << setfill ('0');
    trame << "AT$SF=";
    trame << hex << setw(4) << field1 <<  setw(4) << field2;
    trame << setw(4) << field3 <<  setw(2) << field4;
    trame << setw(4) << field5 <<  setw(4) << field6 << setw(2) << type << '\n';

    cout << trame.str() << endl;

    envoyerMessage(fdSerie,trame.str().c_str());
    recevoirMessage(fdSerie, message, '\n');
    printf("%s", message);

    fermerPort(fdSerie);
    return 0;
}

